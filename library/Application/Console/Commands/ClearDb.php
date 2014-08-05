<?php
namespace Application\Console\Commands;

use Application\Application;
use Application\Console\Console;
use Application\Configuration\Configuration;
use Exception;

class ClearDb
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

        $this->console->writeStdout('WARNING! This command will remove ALL existing pastes and tables.');
        $this->console->writeStdout('After cleaning, you must re-sync database schema by command "php cmd/console SyncDb"');
        $this->console->writeStdout('Press any key to continue...', false, null);

        // Key confirmation
        $this->console->commandExecuteConfirmation();

        // Clear
        $this->clear();
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
     * Clear
     * 
     * @return void
     */
    private function clear()
    {
        foreach($this->prepareSchema()['tables'] as $table => $table_fields) {
            $_clearQuery = 'DROP TABLE IF EXISTS ' . $this->config('Database')->prefix . $table;

            $this->console->writeStdout('Removing table "' . $this->config('Database')->prefix . $table . '"...', false, ' ');

            // try-catch
            try {
                $this->data_source->get()->query($_clearQuery);

                $this->console->writeStdout('Succeeded');
            } catch(Exception $exception) {
                die($this->console->writeStdout('Failed', false, null, $exception->getMessage()));
            }
        }
    }
}
