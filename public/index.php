<?php

if (version_compare(phpversion(), '7.3.0', '<')) {
    exit('Requires PHP 7.3 or higher');
}

use SimPas\Application;

require '../vendor/autoload.php';

new Application();
