<?php
namespace Application\Translations;

use Application\Application;
use Application\Configuration\Configuration;
use Application\Exception\AssetNotFound;
use Application\Exception\ExceptionRuntime;

class Translations
{
    use Configuration;

    /**
     * Translation Setup
     * 
     * @throws Application\Exception\ExceptionRuntime
     * @throws Application\Exception\AssetNotFound
     * @return void
     */
    public function __construct()
    {
        // Translations is disabled?
        if($this->config()->translations === false) {
            return false;
        }

        // Locale doesn't exists?
        if($this->config()->translations === true && $this->config()->locale[1] == null) {
            throw new ExceptionRuntime('Locale is required when translation is enabled');
        }

        // Locale file
        $file = Application::makePath('library:Application:Translations:Resources:' . 
            $this->config()->locale[1] . ':LC_MESSAGES:' . $this->config()->translation_domain);

        // Translation not found
        if(file_exists($file . '.po') === false) {
            throw new AssetNotFound(sprintf('Translation file: ++%s+-+ not found', $file . '.po'));
        }

        // Compiled translation not found
        if(file_exists($file . '.mo') === false) {
            throw new AssetNotFound(sprintf('Compiled translation file: ++%s+-+ not found. You must compile the *.po translation file.', $file . '.mo'));
        }

        // Modification time
        $m_time = filemtime($file . '.mo');

        // If doesn't exists, create it, by copying the original MO file
        if(file_exists(Application::makePath('library:Application:Translations:Resources:' . 
            $this->config()->locale[1] . ':LC_MESSAGES:' . $this->config()->translation_domain . '_' . $m_time . '.mo')) === false
        ) {
            copy($file . '.mo', Application::makePath('library:Application:Translations:Resources:' . 
                $this->config()->locale[1] . ':LC_MESSAGES:' . $this->config()->translation_domain . '_' . $m_time . '.mo'));
        }

        // Set environment value
        putenv('LC_ALL=' . $this->config()->locale[1]);

        // Set default locale
        setlocale(LC_ALL, $this->config()->locale[1]);
        setlocale(LC_TIME, $this->config()->locale[1]);

        // Set path for domain
        bindtextdomain($this->config()->translation_domain . '_' . $m_time, Application::makePath('library:Application:Translations:Resources'));

        // Set text for domain
        textdomain($this->config()->translation_domain . '_' . $m_time);
    }
}
