<?php
namespace Application\Console\Commands;

use Application\Application;
use Application\Console\Console;
use Application\FileManager\FileManager;

class CheckUpdates
{
    /**
     * Console
     * 
     * @var object
     */
    private $console;

    /**
     * File manager
     * 
     * @var object
     */
    private $file_manager;

    /**
    * Construct
    * 
    * @param Console $console
    * @return void
    */
    public function __construct(Console $console)
    {
        $this->console = $console;
        $this->file_manager = new FileManager();

        $this->getServerResponse();
    }

    /**
    * Server response
    * 
    * @return bool|string
    */
    private function getServerResponse()
    {
        // Download version
        $_json_source = $this->file_manager->getContentsFromUrl(sprintf('http://www.macsch15.pl/project/simpas/update/?version=%d', Application::VERSION_LONG));

        $this->console->writeStdout('Downloading version from server...', false, ' ');

        // Status
        if((int)$this->file_manager->curlResultContainer()->http_code === 200) {
            $this->console->writeStdout(sprintf('(Code %d) Succeeded (Took %s)', (int)$this->file_manager->curlResultContainer()->http_code, $this->file_manager->curlResultContainer()->total_time));
        } else {
            die($this->console->writeStdout(sprintf('(Code %d) Failed', (int)$this->file_manager->curlResultContainer()->http_code)));
        }

        // Decode
        $_json_source = json_decode($_json_source, true);

        $this->console->writeStdout('Comparing versions...', false, PHP_EOL . PHP_EOL);

        // Test
        if($_json_source['new_version_available'] === '1') {
            return $this->console->writeStdout('Result: New release of SimPas is available! Check out on https://github.com/Macsch15/SimPas/releases');
        } 

        return $this->console->writeStdout('Result: You use the latest release of SimPas.');
    }
}
