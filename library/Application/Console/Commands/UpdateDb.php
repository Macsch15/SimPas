<?php
namespace Application\Console\Commands;

use Application\Application;
use Application\Console\Console;
use Application\Configuration\Configuration;
use Exception;

class UpdateDb
{
    use Configuration;

    /**
     * DataBase
     * 
     * @var object
     */
    private $data_source;

    /**
     * Console
     * 
     * @var object
     */
    private $console;

    /**
     * Construct
     * 
     * @param Console $console
     * @param Application $application
     * @return void
     */
    public function __construct(Console $console, Application $application)
    {
        $this->data_source = $application->dbConnectionAccessor();
        $this->console = $console;

        // Re-sync schema
        $this->reSyncSchema();
    }

    /**
     * Prepare database schema
     * 
     * @return array
     */
    private function prepareSchema()
    {
        $this->console->writeStdout('Preparing database schema...', false, ' ');

        // Load schema
        $schema_file = $this->data_source->getSchema();

        // Schema test
        if($schema_file !== false) {
            $this->console->writeStdout('Succeeded');
        } else {
            die($this->console->writeStdout('Failed'));
        }

        return $schema_file;
    }

    /**
     * Update database schema
     * 
     * @return void
     */
    private function reSyncSchema()
    {
        $this->console->writeStdout('Selected driver: ' . $this->config('Database')->driver);

        // Get all tables from db
        if($this->config('Database')->driver === 'mysql') {
            foreach($this->data_source->get()->query('SHOW TABLES')->fetchAll() as $key => $value) {
                $tables_in_db[] = $value[0];
            }            
        } elseif($this->config('Database')->driver === 'postgresql') {
            // Prepare query
            $table_exists = $this->data_source->get()->prepare('SELECT * FROM information_schema.tables WHERE table_schema = :public');

            // Filter
            $table_exists->bindValue(':public', 'public');

            // Execute
            $table_exists->execute();

            foreach($table_exists->fetchAll() as $key => $value) {
                $tables_in_db[] = $value['table_name'];
            }
        }

        foreach($this->prepareSchema()['tables'] as $table => $table_fields) {
            switch($this->config('Database')->driver) {
                case 'mysql':
                    // Add new tables
                    if(in_array($this->config('Database')->prefix . $table, $tables_in_db, true) === false) {
                        $_createTableQuery = 'CREATE TABLE ' . $this->config('Database')->prefix . $table . '( ';

                        foreach($table_fields as $field_name => $field_value) {
                            // Ignore
                            if($field_name === '__options__') {
                                continue;
                            }

                            // Fields
                            $_createTableQuery .= '`' . $field_name . '` ' . $field_value . ',';
                        }

                        // Table options
                        $_createTableQuery .= 'PRIMARY KEY(' . $table_fields['__options__']['primary_key'] . ')) ENGINE=' . $table_fields['__options__']['engine'];
                        $_createTableQuery .= ' DEFAULT CHARSET=\'' . $this->config('Database')->charset . '\' DEFAULT COLLATE=\'' . $this->config('Database')->collate . '\';';

                        $this->console->writeStdout('Creating new table "' . $this->config('Database')->prefix . $table . '"...', false, ' ');
                        
                        // try-catch
                        try {
                            // Execute
                            $this->data_source->get()->query($_createTableQuery);

                            $this->console->writeStdout('Succeeded');
                        } catch(Exception $exception) {
                            die($this->console->writeStdout('Failed', false, null, $exception->getMessage()));
                        }
                    }

                    // Add new columns
                    foreach($table_fields as $field_name => $field_value) {
                        // Ignore
                        if($field_name === '__options__') {
                            continue;
                        }

                        // Prepare query
                        $field_exists = $this->data_source->get()->prepare('SHOW COLUMNS FROM ' . $this->config('Database')->prefix . $table . ' WHERE Field= :field');

                        // Filter
                        $field_exists->bindValue(':field', $field_name);

                        // Execute
                        $field_exists->execute();

                        // Test
                        if(!count($field_exists->fetchAll())) {
                            // Add new field
                            $this->data_source->get()->query('ALTER TABLE ' . $this->config('Database')->prefix . $table . ' ADD ' . '`' . $field_name . '` ' . $field_value);

                            // Send the message
                            $this->console->writeStdout('Added new fields: ' . $field_name);
                        }
                    }
                    break;
                case 'postgresql':
                    // Add new tables
                    if(in_array($this->config('Database')->prefix . $table, $tables_in_db, true) === false) {
                        $_createTableQuery = 'CREATE TABLE ' . $this->config('Database')->prefix . $table . '( ';

                        foreach($table_fields as $field_name => $field_value) {
                            // Ignore
                            if($field_name === '__options__') {
                                continue;
                            }

                            // Fields
                            $_createTableQuery .= $field_name . ' ' . $field_value . ',';
                        }

                        $_createTableQuery = substr($_createTableQuery, 0, -1) . ');';

                        $this->console->writeStdout('Creating new table "' . $this->config('Database')->prefix . $table . '"...', false, ' ');
                        
                        // try-catch
                        try {
                            // Execute
                            $this->data_source->get()->query($_createTableQuery);

                            $this->console->writeStdout('Succeeded');
                        } catch(Exception $exception) {
                            die($this->console->writeStdout('Failed', false, null, $exception->getMessage()));
                        }
                    }

                    // Add new columns
                    foreach($table_fields as $field_name => $field_value) {
                        // Ignore
                        if($field_name === '__options__') {
                            continue;
                        }

                        // Prepare query
                        $field_exists = $this->data_source->get()->prepare('
                            SELECT column_name 
                            FROM information_schema.columns 
                            WHERE table_name=:table and column_name=:field_name');

                        // Filter
                        $field_exists->bindValue(':table', $this->config('Database')->prefix . $table);
                        $field_exists->bindValue(':field_name', $field_name);

                        // Execute
                        $field_exists->execute();

                        if(!count($field_exists->fetchAll())) {
                            // Add new field
                            $this->data_source->get()->query('ALTER TABLE ' . $this->config('Database')->prefix . $table . ' ADD ' . $field_name . ' ' . $field_value);

                            // Send the message
                            $this->console->writeStdout('Added field: ' . $field_name . ' to ' . $this->config('Database')->prefix . $table);
                        }
                    }                
                    break;
            }
        }

        $this->console->writeStdout('Database successfully updated');
    }
}
