<?php

namespace SimPas\Console\Commands;

use SimPas\Application;
use SimPas\Configuration\Configuration;
use SimPas\Console\Console;
use Exception;

class UpdateDb
{
    use Configuration;

    private $data_source;
    private $console;

    /**
     * UpdateDb constructor.
     * @param Console $console
     * @param Application $application
     * @throws \SimPas\Exception\ExceptionRuntime
     */
    public function __construct(Console $console, Application $application)
    {
        $this->data_source = $application->dbConnectionAccessor();
        $this->console = $console;

        $this->reSyncSchema();
    }

    /**
     * @return array|bool
     */
    private function prepareSchema()
    {
        $this->console->writeStdout('Preparing database schema...', false, ' ');

        $schema_file = $this->data_source->getSchema();

        if ($schema_file !== false) {
            $this->console->writeStdout('Succeeded');
        } else {
            exit($this->console->writeStdout('Failed'));
        }

        return $schema_file;
    }

    /**
     * Update database schema.
     *
     * @return void
     */
    private function reSyncSchema()
    {
        $this->console->writeStdout('Selected driver: ' . $this->config('database')['driver']);

        if ($this->config('database')['driver'] === 'mysql') {
            foreach ($this->data_source->get()->query('SHOW TABLES')->fetchAll() as $key => $value) {
                $tables_in_db[] = $value[0];
            }
        } elseif ($this->config('database')['driver'] === 'postgresql') {
            $table_exists = $this->data_source->get()->prepare('SELECT * FROM information_schema.tables WHERE table_schema = :public');
            $table_exists->bindValue(':public', 'public');
            $table_exists->execute();

            foreach ($table_exists->fetchAll() as $key => $value) {
                $tables_in_db[] = $value['table_name'];
            }
        }

        foreach ($this->prepareSchema()['tables'] as $table => $table_fields) {
            switch ($this->config('database')['driver']) {
                case 'mysql':
                    if (in_array($this->config('database')['prefix'] . $table, $tables_in_db, true) === false) {
                        $_createTableQuery = 'CREATE TABLE ' . $this->config('database')['prefix'] . $table . '( ';

                        foreach ($table_fields as $field_name => $field_value) {
                            if ($field_name === '__options__') {
                                continue;
                            }

                            $_createTableQuery .= '`' . $field_name . '` ' . $field_value . ',';
                        }

                        $_createTableQuery .= 'PRIMARY KEY(' . $table_fields['__options__']['primary_key'] . ')) ENGINE=' . $table_fields['__options__']['engine'];
                        $_createTableQuery .= ' DEFAULT CHARSET=\'' . $this->config('database')['charset'] . '\' DEFAULT COLLATE=\'' . $this->config('database')['collate'] . '\';';

                        $this->console->writeStdout('Creating new table "' . $this->config('database')['prefix'] . $table . '"...', false, ' ');

                        try {
                            $this->data_source->get()->query($_createTableQuery);

                            $this->console->writeStdout('Succeeded');
                        } catch (Exception $exception) {
                            exit($this->console->writeStdout('Failed', false, null, $exception->getMessage()));
                        }
                    }

                    foreach ($table_fields as $field_name => $field_value) {
                        if ($field_name === '__options__') {
                            continue;
                        }

                        $field_exists = $this->data_source->get()->prepare('SHOW COLUMNS FROM ' . $this->config('database')['prefix'] . $table . ' WHERE Field= :field');
                        $field_exists->bindValue(':field', $field_name);
                        $field_exists->execute();

                        if (!count($field_exists->fetchAll())) {
                            $this->data_source->get()->query('ALTER TABLE ' . $this->config('database')['prefix'] . $table . ' ADD ' . '`' . $field_name . '` ' . $field_value);

                            $this->console->writeStdout('Added new fields: ' . $field_name);
                        }
                    }
                    break;
                case 'postgresql':
                    if (in_array($this->config('database')['prefix'] . $table, $tables_in_db, true) === false) {
                        $_createTableQuery = 'CREATE TABLE ' . $this->config('database')['prefix'] . $table . '( ';

                        foreach ($table_fields as $field_name => $field_value) {
                            if ($field_name === '__options__') {
                                continue;
                            }

                            $_createTableQuery .= $field_name . ' ' . $field_value . ',';
                        }

                        $_createTableQuery = substr($_createTableQuery, 0, -1) . ');';

                        $this->console->writeStdout('Creating new table "' . $this->config('database')['prefix'] . $table . '"...', false, ' ');

                        try {
                            $this->data_source->get()->query($_createTableQuery);

                            $this->console->writeStdout('Succeeded');
                        } catch (Exception $exception) {
                            exit($this->console->writeStdout('Failed', false, null, $exception->getMessage()));
                        }
                    }

                    foreach ($table_fields as $field_name => $field_value) {
                        if ($field_name === '__options__') {
                            continue;
                        }

                        $field_exists = $this->data_source->get()->prepare('
                            SELECT column_name 
                            FROM information_schema.columns 
                            WHERE table_name=:table and column_name=:field_name');

                        $field_exists->bindValue(':table', $this->config('database')['prefix'] . $table);
                        $field_exists->bindValue(':field_name', $field_name);
                        $field_exists->execute();

                        if (!count($field_exists->fetchAll())) {
                            $this->data_source->get()->query('ALTER TABLE ' . $this->config('database')['prefix'] . $table . ' ADD ' . $field_name . ' ' . $field_value);

                            $this->console->writeStdout('Added field: ' . $field_name . ' to ' . $this->config('database')['prefix'] . $table);
                        }
                    }
                    break;
            }
        }

        $this->console->writeStdout('Database successfully updated');
    }
}
