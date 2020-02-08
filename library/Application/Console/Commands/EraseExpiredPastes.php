<?php
namespace Application\Console\Commands;

use Application\Application;
use Application\Console\Console;
use Application\Configuration\Configuration;
use Application\Pastebin\PasteExpire;
use Exception;

class EraseExpiredPastes
{
    use Configuration;

    /**
     * Application
     * 
     * @var object
     */
    private $application;

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
        $this->application = $application;
        $this->data_source = $this->application->dbConnectionAccessor();
        $this->console = $console;

        $this->console->writeStdout('WARNING! This command will erase all EXPIRED pastes.');
        $this->console->writeStdout('Press "Enter" to continue...', false, null);

        // Key confirmation
        $this->console->commandExecuteConfirmation();

        // Remove expired pastes
        $this->eraseExpired();
    }

    /**
     * Erase expired pastes
     * 
     * @return void
     */
    private function eraseExpired()
    {
        $this->console->writeStdout('Starting...');

        // Start query
        $query = $this->data_source
        ->get()
        ->query('SELECT unique_id FROM ' . $this->config('database')['prefix'] . 'pastes');

        foreach($query as $row) {
            // Paste expired?
            if((new PasteExpire($this->application))->isExpired($row['unique_id']) === true) {
                $this->console->writeStdout('Removing ' . $row['unique_id'] . '...');

                // Prepare query
                $query = $this->data_source
                ->get()
                ->prepare('DELETE FROM ' . $this->config('database')['prefix'] . 'pastes WHERE unique_id = :paste_id');

                // Filter and execute
                $query->bindValue(':paste_id', $row['unique_id'], constant('PDO::PARAM_INT'));
                $query->execute();
            }
        }

        $this->console->writeStdout('Done.');
    }
}
