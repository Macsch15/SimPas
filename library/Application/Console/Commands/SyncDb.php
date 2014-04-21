<?php
namespace Application\Console\Commands;

use Application\Application;
use Application\Console\Console;
use Application\Configuration\Configuration;
use Exception;

class SyncDb
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

        // Sync
        $this->sync();
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
    * Sync
    * 
    * @return void
    */
    private function sync()
    {
        $tables = $this->prepareSchema();

        foreach($tables['tables'] as $table => $table_fields) {
            if(count($this->data_source->get()->query('SHOW TABLES')->fetchAll())) {
                // Table already exists? Check whether new fields has been added
                foreach($table_fields as $field_name => $field_value) {
                    // Ignore
                    if($field_name === '__options__') {
                        continue;
                    }

                    $field_exists = $this->data_source->get()->query('SHOW COLUMNS FROM ' . $this->config('Database')->prefix . $table . ' WHERE Field = "' . $field_name . '"')->fetchAll();

                    if(!count($field_exists)) {
                        // Add new field
                        $this->data_source->get()->query('ALTER TABLE ' . $this->config('Database')->prefix . $table . ' ADD ' . '`' . $field_name . '` ' . $field_value);

                        // Send the message
                        $this->console->writeStdout('Added field: ' . $field_name);
                    }
                }

                return $this->console->writeStdout('Succeeded');
            }

            // Table
            $_createTablesQuery = 'CREATE TABLE IF NOT EXISTS ' . $this->config('Database')->prefix . $table . '( ';

            foreach($table_fields as $field_name => $field_value) {
                // Ignore
                if($field_name === '__options__') {
                    continue;
                }

                // Fields
                $_createTablesQuery .= '`' . $field_name . '` ' . $field_value . ', ';
            }

            // Table options
            $_createTablesQuery .= 'PRIMARY KEY(' . $table_fields['__options__']['primary_key'] . ')) ENGINE=' . $table_fields['__options__']['engine'];
            $_createTablesQuery .= ' DEFAULT CHARSET=\'' . $this->config('Database')->charset . '\' DEFAULT COLLATE=\'' . $this->config('Database')->collate . '\';';

            $this->console->writeStdout('Creating table "' . $this->config('Database')->prefix . $table . '"...', false, ' ');
            
            // try-catch
            try {
                $this->data_source->get()->query($_createTablesQuery);

                $this->console->writeStdout('Succeeded');
            } catch(Exception $exception) {
                die($this->console->writeStdout('Failed', false, null, $exception->getMessage()));
            }
        }

        // Final message
        $this->console->writeStdout(null);
        $this->console->writeStdout('SimPas is ready for work now. Visit your home site: ' . $this->config()->full_url);
    }
}
