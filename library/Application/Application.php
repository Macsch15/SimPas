<?php
namespace Application;

use Application\Exception\ExceptionRuntime;
use Application\Exception\ExceptionInvalidArgument;
use Application\View\View;
use Application\Translations\Translations;
use Application\Routing\Routing;
use Application\Configuration\Configuration;
use Application\Console\Console;
use Application\DataSources\MySQL\Driver as DatabaseDriver;

class Application
{
    use Configuration;

    /**
    * PHP errors container
    * 
    * @var array
    */
    private $php_errors_container;

    /**
     * Application enviorment
     * dev|prod
     * 
     * @return string
     */
    const ENVIORMENT = 'dev';

    /**
    * Template cache
    * 
    * @return bool
    */
    const TEMPLATE_CACHE = true;

    /**
     * Application version
     * 
     * @return string
     */
    const VERSION = '0.4';

    /**
     * Application version long
     * 
     * @return string
     */
    const VERSION_LONG = '0400';

    /**
     * Application name
     * 
     * @return string
     */
    const NAME = 'SimPas';

    /**
     * Main application constructor
     *
     * @param array $cmd_argv
     * @return void
     */
    public function __construct(array $cmd_argv = [])
    {
        // CLI request
        if(strtolower(php_sapi_name()) === 'cli') {
            new Console($this, $cmd_argv);
            die();
        }

        // Error level
        if(Application::ENVIORMENT === 'dev') {
            // All errors
            error_reporting(E_ALL);
            // Error handler
            set_error_handler([$this, 'engineErrorsHandler']);
        } else {
            // No errors
            error_reporting(0);
            // Error handler
            set_error_handler([$this, 'engineErrorsHandler'], 0);
        }
        
        // Timezone settings
        if(!ini_get('date.timezone')) {
            @date_default_timezone_set($this->config()->default_timezone);
        }

        // Try-catch
        try {
            // Translations
            new Translations();

            // Routing
            new Routing($this);
        } catch(ExceptionRuntime $exception) {
            (new View($this))->drawExceptionMessage($exception, 'Runtime');
        } catch(ExceptionInvalidArgument $exception) {
            (new View($this))->drawExceptionMessage($exception, 'InvalidArgument');
        } catch(\Exception $exception) {
            (new View($this))->drawExceptionMessage($exception);
        }
    }

    /**
     * Make root path
     * 
     * @param string $path 
     * @return string
     */
    public static function makePath($path = null)
    {
        $path = str_replace(':', DIRECTORY_SEPARATOR, $path);

        return __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $path;
    }

    /**
    * Database connection accessor
    * 
    * @return DatabaseDriver object
    */
    public function dbConnectionAccessor()
    {
        return new DatabaseDriver();
    }

    /**
    * PHP errors handler
    * 
    * @param int $errno
    * @param string $errstr
    * @param string $errfile
    * @param int $errline 
    * @return void
    */
    public function engineErrorsHandler($errno, $errstr, $errfile, $errline)
    {
        $this->php_errors_container[] = sprintf(_('%s on line %d in file %s'), $errstr, $errline, $errfile);;
    }

    /**
    * Fetch PHP errors
    * 
    * @return array
    */
    public function engineErrors()
    {
        return $this->php_errors_container;
    }

    /**
    * Utilised memory (in KB)
    *
    * @return string
    */
    public function getUtilisedMemory()
    {
        return round(memory_get_peak_usage() / 1024);
    }
}
