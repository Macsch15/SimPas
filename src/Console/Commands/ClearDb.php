<?php

namespace SimPas\Console\Commands;

use SimPas\Application;
use SimPas\Configuration\Configuration;
use SimPas\Console\Console;
use Exception;

class ClearDb
{
    use Configuration;

    /**
     * DataBase.
     *
     * @var object
     */
    private $data_source;

    /**
     * Console.
     *
     * @var object
     */
    private $console;

    /**
     * Construct.
     *
     * @param Console $console
     * @param Application $application
     *
     * @return void
     * @throws \SimPas\Exception\ExceptionRuntime
     *
     */
    public function __construct(Console $console, Application $application)
    {
        $this->data_source = $application->dbConnectionAccessor();
        $this->console = $console;

        $this->console->writeStdout('WARNING! This command will remove ALL existing pastes and tables.');
        $this->console->writeStdout('After cleaning, you must re-sync database schema by command "php cmd/console SyncDb"');
        $this->console->writeStdout('Press "Enter" to continue...', false, null);

        $this->console->commandExecuteConfirmation();

        $this->clear();
    }

    /**
     * Prepare database schema.
     *
     * @return array
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
     * Clear.
     *
     * @return void
     */
    private function clear()
    {
        foreach ($this->prepareSchema()['tables'] as $table => $table_fields) {
            $_clearQuery = 'DROP TABLE IF EXISTS ' . $this->config('database')['prefix'] . $table;

            $this->console->writeStdout('Removing table "' . $this->config('database')['prefix'] . $table . '"...', false, ' ');

            try {
                $this->data_source->get()->query($_clearQuery);

                $this->console->writeStdout('Succeeded');
            } catch (Exception $exception) {
                exit($this->console->writeStdout('Failed', false, null, $exception->getMessage()));
            }
        }
    }
}
