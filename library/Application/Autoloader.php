<?php
namespace Application;

class Autoloader
{
    /**
     * Autoloader
     * 
     * @return void
     */
    public function __construct()
    {
        $directory = substr(__DIR__, 0, strripos(__DIR__, DIRECTORY_SEPARATOR)) . DIRECTORY_SEPARATOR;

        // Register autoload
        spl_autoload_register(function ($class) use ($directory) {
            // Class already exists?
            if (class_exists($class, false)) {
                return true;
            }

            // Normalize class name
            if (preg_match('/[^A-Za-z0-9\\\_]/', $class)) {
                return false;
            }

            // Final class name with correctly directory
            $class .= '.php';
            $class = $directory . str_replace(['_', '\\', '\0'], DIRECTORY_SEPARATOR, $class);

            if (is_file($class) && file_exists($class)) {
                require_once $class;
            }

            // Ouch.
            return false;
        });
    }
}
