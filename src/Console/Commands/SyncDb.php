<?php

namespace SimPas\Console\Commands;

use SimPas\Application;
use SimPas\Configuration\Configuration;
use SimPas\Console\Console;
use Exception;

class SyncDb
{
    use Configuration;

    private $data_source;
    private $console;

    /**
     * SyncDb constructor.
     * @param Console $console
     * @param Application $application
     * @throws \SimPas\Exception\ExceptionRuntime
     */
    public function __construct(Console $console, Application $application)
    {
        $this->data_source = $application->dbConnectionAccessor();
        $this->console = $console;

        $this->sync();
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
     * @return void
     */
    private function sync(): void
    {
        $this->console->writeStdout('Selected driver: ' . $this->config('database')['driver']);

        foreach ($this->prepareSchema()['tables'] as $table => $table_fields) {
            switch ($this->config('database')['driver']) {
                case 'mysql':
                default:
                    $_createTablesQuery = 'CREATE TABLE IF NOT EXISTS ' . $this->config('database')['prefix'] . $table . '( ';

                    foreach ($table_fields as $field_name => $field_value) {
                        if ($field_name === '__options__') {
                            continue;
                        }

                        $_createTablesQuery .= '`' . $field_name . '` ' . $field_value . ',';
                    }

                    $_createTablesQuery .= 'PRIMARY KEY(' . $table_fields['__options__']['primary_key'] . ')) ENGINE=' . $table_fields['__options__']['engine'];
                    $_createTablesQuery .= ' DEFAULT CHARSET=\'' . $this->config('database')['charset'] . '\' DEFAULT COLLATE=\'' . $this->config('database')['collate'] . '\';';
                    break;
                case 'postgresql':
                    $_createTablesQuery = 'CREATE TABLE IF NOT EXISTS ' . $this->config('database')['prefix'] . $table . '( ';

                    foreach ($table_fields as $field_name => $field_value) {
                        if ($field_name === '__options__') {
                            continue;
                        }

                        $_createTablesQuery .= $field_name . ' ' . $field_value . ',';
                    }

                    $_createTablesQuery = substr($_createTablesQuery, 0, -1) . ');';
                    break;
            }

            $this->console->writeStdout('Creating table "' . $this->config('database')['prefix'] . $table . '"...', false, ' ');

            try {
                $this->data_source->get()->query($_createTablesQuery);

                $this->console->writeStdout('Succeeded');
            } catch (Exception $exception) {
                exit($this->console->writeStdout('Failed', false, null, $exception->getMessage()));
            }
        }

        $this->console->writeStdout(null);
        $this->console->writeStdout('SimPas is ready for work now. Visit your home site: ' . $this->config()['full_url']);
    }
}
