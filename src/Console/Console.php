<?php

namespace SimPas\Console;

use SimPas\Application;

class Console
{
    private $commands = [
        'SyncDb',
        'ClearDb',
        'CacheRebuild',
        'EraseExpiredPastes',
        'UpdateDb',
    ];

    /**
     * Console constructor.
     * @param Application $application
     * @param array $cmd_argv
     */
    public function __construct(Application $application, array $cmd_argv)
    {
        if (count($cmd_argv) <= 1) {
            return $this->availableCommands();
        }

        array_shift($cmd_argv);

        foreach ($cmd_argv as $arguments) {
            if (in_array($arguments, $this->availableCommands(true), true) === false) {
                return $this->availableCommands();
            }

            $arguments = 'SimPas\\Console\\Commands\\' . $arguments;

            new $arguments($this, $application);
        }
    }

    /**
     * @param false $as_array
     * @return string[]
     */
    private function availableCommands(bool $as_array = false)
    {
        if ($as_array) {
            return $this->commands;
        }

        $this->writeStdout('Available commands:');

        foreach ($this->commands as $command) {
            $this->writeStdout('php cmd/console ' . $command, true);
        }
    }

    /**
     * @param $message
     * @param false $list
     * @param string $line_separator
     * @param false $error_message
     * @return false|int
     */
    public function writeStdout($message, bool $list = false, $line_separator = PHP_EOL, bool $error_message = false)
    {
        if ($list === true) {
            $message = '> ' . $message;
        }

        if ($error_message) {
            $error_encountered = str_repeat('-', 15) . 'ERROR MESSAGE' . str_repeat('-', 15);
            $message .= PHP_EOL . $error_encountered . PHP_EOL . $error_message . PHP_EOL . $error_encountered;
        }

        $line_separator = ($line_separator === null ? PHP_EOL : $line_separator);

        return @file_put_contents('php://stdout', $message . $line_separator);
    }

    /**
     * @return false|string
     */
    public function commandExecuteConfirmation()
    {
        return fgets(fopen('php://stdin', 'r'));
    }
}
