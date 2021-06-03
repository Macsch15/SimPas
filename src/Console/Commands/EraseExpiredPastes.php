<?php

namespace SimPas\Console\Commands;

use SimPas\Application;
use SimPas\Configuration\Configuration;
use SimPas\Console\Console;
use SimPas\Pastebin\PasteExpire;

class EraseExpiredPastes
{
    use Configuration;

    private $application;
    private $data_source;
    private $console;

    /**
     * EraseExpiredPastes constructor.
     * @param Console $console
     * @param Application $application
     * @throws \SimPas\Exception\ExceptionRuntime
     */
    public function __construct(Console $console, Application $application)
    {
        $this->application = $application;
        $this->data_source = $this->application->dbConnectionAccessor();
        $this->console = $console;

        $this->console->writeStdout('WARNING! This command will erase all EXPIRED pastes.');
        $this->console->writeStdout('Press "Enter" to continue...', false, null);

        $this->console->commandExecuteConfirmation();

        $this->eraseExpired();
    }

    /**
     * @throws \SimPas\Exception\ExceptionRuntime
     */
    private function eraseExpired()
    {
        $this->console->writeStdout('Starting...');

        $query = $this->data_source
            ->get()
            ->query('SELECT unique_id FROM ' . $this->config('database')['prefix'] . 'pastes');

        foreach ($query as $row) {
            if ((new PasteExpire($this->application))->isExpired($row['unique_id']) === true) {
                $this->console->writeStdout('Removing ' . $row['unique_id'] . '...');

                $query = $this->data_source
                    ->get()
                    ->prepare('DELETE FROM ' . $this->config('database')['prefix'] . 'pastes WHERE unique_id = :paste_id');

                $query->bindValue(':paste_id', $row['unique_id'], constant('PDO::PARAM_INT'));
                $query->execute();
            }
        }

        $this->console->writeStdout('Done.');
    }
}
