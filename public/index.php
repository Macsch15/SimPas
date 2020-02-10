<?php
if (version_compare(phpversion(), '7.3.0', '<')) {
    die('Requires PHP 7.3 or higher');
}

use Application\Application;

require '../vendor/autoload.php';

new Application();
