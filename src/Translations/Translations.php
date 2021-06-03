<?php

namespace SimPas\Translations;

use SimPas\Application;
use SimPas\Configuration\Configuration;
use SimPas\Exception\AssetNotFound;
use SimPas\Exception\ExceptionRuntime;

class Translations
{
    use Configuration;

    /**
     * Translation Setup.
     *
     * @return void
     * @throws ExceptionRuntime
     *
     * @throws AssetNotFound
     */
    public function __construct()
    {
        if ($this->config()['translations'] === false) {
            return;
        }

        if ($this->config()['translations'] === true && $this->config()['locale'][1] == null) {
            throw new ExceptionRuntime('Locale is required when translation is enabled');
        }

        $file = Application::makePath('library:Application:Translations:Resources:' .
            $this->config()['locale'][1] . ':LC_MESSAGES:' . $this->config()['translation_domain']);

        if (file_exists($file . '.po') === false) {
            throw new AssetNotFound(sprintf('Translation file: ++%s+-+ not found', $file . '.po'));
        }

        if (file_exists($file . '.mo') === false) {
            throw new AssetNotFound(sprintf('Compiled translation file: ++%s+-+ not found. You must compile the *.po translation file.', $file . '.mo'));
        }

        $m_time = filemtime($file . '.mo');

        if (file_exists(Application::makePath('library:Application:Translations:Resources:' .
                $this->config()['locale'][1] . ':LC_MESSAGES:' . $this->config()['translation_domain'] . '_' . $m_time . '.mo')) === false
        ) {
            copy($file . '.mo', Application::makePath('library:Application:Translations:Resources:' .
                $this->config()['locale'][1] . ':LC_MESSAGES:' . $this->config()['translation_domain'] . '_' . $m_time . '.mo'));
        }

        putenv('LC_ALL=' . $this->config()['locale'][1]);

        setlocale(LC_ALL, $this->config()['locale'][1]);
        setlocale(LC_TIME, $this->config()['locale'][1]);

        bindtextdomain($this->config()['translation_domain'] . '_' . $m_time, Application::makePath('library:Application:Translations:Resources'));
        textdomain($this->config()['translation_domain'] . '_' . $m_time);
    }
}
