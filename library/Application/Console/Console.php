<?php
namespace Application\Console;

use Application\Application;

class Console
{
    /**
     * Commands
     * 
     * @var array
     */
    private $commands = [
        'SyncDb',
        'ClearDb',
        'CacheRebuild',
        'EraseExpiredPastes',
        'UpdateDb'
    ];

    /**
     * Construct
     *
     * @param Application $application
     * @param array $cmd_argv
     * @return void
     */
    public function __construct(Application $application, array $cmd_argv)
    {
        // Command without arguments?
        if(count($cmd_argv) <= 1) {
            return $this->avaiableCommands();
        }

        // Shift first value of array
        array_shift($cmd_argv);

        foreach($cmd_argv as $arguments) {
            // Arguments validation
            if(in_array($arguments, $this->avaiableCommands(true), true) === false) {
                return $this->avaiableCommands();
            }

            // Add namespace
            $arguments = 'Application\\Console\\Commands\\' . $arguments;

            // Run the command controller
            new $arguments($this, $application);
        }
    }

    /**
     * Avaiable commands
     *
     * @param bool $as_array
     * @return string|array
     */
    private function avaiableCommands($as_array = false)
    {
        if($as_array) {
            return $this->commands;
        }

        $this->writeStdout('Avaiable commands:');

        foreach($this->commands as $command) {
            $this->writeStdout('php cmd/console ' . $command, true);
        }
    }

    /**
     * Write message to stdout
     * 
     * @param string $message 
     * @param bool $list
     * @param string $line_separator
     * @param string $error_message
     * @return void
     */
    public function writeStdout($message, $list = false, $line_separator = PHP_EOL, $error_message = false)
    {
        if($list === true) {
            $message = '> ' . $message;
        }

        if($error_message) {
            $error_encountered = str_repeat('-', 15) . 'ERROR MESSAGE' . str_repeat('-', 15);
            $message .= PHP_EOL . $error_encountered . PHP_EOL . $error_message . PHP_EOL . $error_encountered;
        }

        $line_separator = ($line_separator === null ? PHP_EOL : $line_separator);

        return @file_put_contents('php://stdout', $message . $line_separator);
    }

    /**
     * Confirmation
     * 
     * @return void
     */
    public function commandExecuteConfirmation()
    {
        return fgets(fopen('php://stdin', 'r'));
    }
}
