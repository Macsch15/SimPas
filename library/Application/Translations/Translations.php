<?php
namespace Application\Translations;

use Application\Application;
use Application\Configuration\Configuration;
use Application\Exception\ExceptionRuntime;

class Translations
{
    use Configuration;

    /**
     * Translation Setup
     * 
     * @param Application $application
     * @throws Application\Exception\ExceptionRuntime
     * @return void
     */
    public function __construct()
    {
        // Translations is disabled?
        if($this->config()->translations === false) {
            return false;
        }

        // Load locale
        $locale = $this->config()->locale[1];

        // Locale doesn't exists?
        if($this->config()->translations === true && $locale == null) {
            throw new ExceptionRuntime('Locale is required when translation is enabled');
        }

        // Locale domain
        $domain = 'messages';

        // Locale file
        $file = Application::makePath('library:Application:Translations:Resources:' . $locale . ':LC_MESSAGES:' . $domain);

        // Translation not found
        if(file_exists($file . '.po') === false) {
            throw new ExceptionRuntime(sprintf('Translation file: ++%s+-+ not found', $file . '.po'));
        }

        // Modification time
        $m_time = filemtime($file . '.mo');

        // If doesn't exists, create it, by copying the original MO file
        if(file_exists(Application::makePath('library:Application:Translations:Resources:' . $locale . ':LC_MESSAGES:' . $domain . '_' . $m_time . '.mo')) === false) {
            copy($file . '.mo', Application::makePath('library:Application:Translations:Resources:' . $locale . ':LC_MESSAGES:' . $domain . '_' . $m_time . '.mo'));
        }

        // Set enviorment value
        putenv('LC_ALL=' . $locale);

        // Set default locale
        setlocale(LC_ALL, $locale);
        setlocale(LC_TIME, $locale);

        // Set path for domain
        bindtextdomain($domain . '_' . $m_time, Application::makePath('library:Application:Translations:Resources'));

        // Set text for domain
        textdomain($domain . '_' . $m_time);
    }
}
