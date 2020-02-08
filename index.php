<?php
if (version_compare(phpversion(), '7.3.0', '<')) {
    die('Requires PHP 7.3 or higher');
}

use Application\Autoloader;
use Application\Application;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'library' . 
    DIRECTORY_SEPARATOR . 'Application' . 
    DIRECTORY_SEPARATOR . 'Autoloader.php';

new Autoloader();
new Application();