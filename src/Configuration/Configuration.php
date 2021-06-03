<?php

namespace SimPas\Configuration;

use SimPas\Application;
use SimPas\Exception\AssetNotFound;

trait Configuration
{
    /**
     * Load Configuration File.
     *
     * @param string $module
     *
     * @return array
     */
    public function config($module = 'app')
    {
        try {
            $configPath = Application::makePath('config:' . $module . '.php');

            if (file_exists($configPath) === false) {
                throw new AssetNotFound(sprintf('Undefined configuration file "%s"', $module));
            }

            return array_merge(require $configPath);
        } catch (AssetNotFound $exception) {
            header('HTTP/1.1 502 Bad Gateway', true, 502);

            exit($exception->getMessage());
        }
    }
}
