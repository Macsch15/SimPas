<?php

namespace SimPas;

use SimPas\Configuration\Configuration;
use SimPas\Console\Console;
use SimPas\DataSources\MySQL\Driver as MysqlDriver;
use SimPas\DataSources\PostgreSQL\Driver as PostgresqlDriver;
use SimPas\Exception\AssetNotFound;
use SimPas\Exception\ExceptionInvalidArgument;
use SimPas\Exception\ExceptionRuntime;
use SimPas\Exception\MailerException;
use SimPas\Routing\Routing;
use SimPas\Translations\Translations;
use SimPas\View\View;

class Application
{
    use Configuration;

    /**
     * PHP errors container.
     *
     * @var array
     */
    private $php_errors_container;

    /**
     * Application environment
     * dev|prod.
     *
     * @return string
     */
    const ENVIRONMENT = 'dev';

    /**
     * Template cache.
     *
     * @return bool
     */
    const TEMPLATE_CACHE = false;

    /**
     * Application version.
     *
     * @return string
     */
    const VERSION = '0.8.0';

    /**
     * Application name.
     *
     * @return string
     */
    const NAME = 'SimPas';

    /**
     * Main application constructor.
     *
     * @param array $cmd_argv
     *
     * @return void
     * @throws \Exception
     *
     */
    public function __construct(array $cmd_argv = [])
    {
        if (strtolower(php_sapi_name()) === 'cli') {
            new Console($this, $cmd_argv);
            exit();
        }

        if (self::ENVIRONMENT === 'dev') {
            error_reporting(E_ALL);
            set_error_handler([$this, 'engineErrorsHandler']);
        } else {
            error_reporting(0);
            set_error_handler([$this, 'engineErrorsHandler'], 0);
        }

        if (!ini_get('date.timezone')) {
            @date_default_timezone_set($this->config()['default_timezone']);
        }

        try {
            if ($this->config()['translations'] === true) {
                new Translations();
            }

            new Routing($this);
        } catch (ExceptionRuntime $exception) {
            (new View($this))->drawExceptionMessage($exception, 'Runtime');
        } catch (ExceptionInvalidArgument $exception) {
            (new View($this))->drawExceptionMessage($exception, 'InvalidArgument');
        } catch (AssetNotFound $exception) {
            (new View($this))->drawExceptionMessage($exception, 'AssetNotFound');
        } catch (MailerException $exception) {
            (new View($this))->drawExceptionMessage($exception, 'MailerException');
        } catch (\Exception $exception) {
            (new View($this))->drawExceptionMessage($exception);
        }
    }

    /**
     * Make root path.
     *
     * @param string $path
     *
     * @return string
     */
    public static function makePath($path = null)
    {
        $path = str_replace(':', DIRECTORY_SEPARATOR, $path);

        return __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $path;
    }

    /**
     * Build URL address.
     *
     * @param string $route
     *
     * @return string
     */
    public function buildUrl($route = null)
    {
        if ($route == null) {
            return $this->config()['full_url'];
        }

        if ($this->config()['show_index_in_urls'] === true) {
            return $this->config()['full_url'] . 'index.php?' . $route;
        } else {
            return $this->config()['full_url'] . $route;
        }
    }

    /**
     * Database connection accessor.
     *
     * @return MysqlDriver|PostgresqlDriver object
     * @throws ExceptionRuntime
     *
     */
    public function dbConnectionAccessor()
    {
        switch ($this->config('database')['driver']) {
            case 'mysql':
            default:
                return new MysqlDriver();
                break;
            case 'postgresql':
                return new PostgresqlDriver();
                break;
        }
    }

    /**
     * PHP errors handler.
     *
     * @param int $errno
     * @param string $errstr
     * @param string $errfile
     * @param int $errline
     *
     * @return void
     */
    public function engineErrorsHandler($errno, $errstr, $errfile, $errline)
    {
        $this->php_errors_container[] = sprintf(_('%s on line %d in file %s'), $errstr, $errline, $errfile);
    }

    /**
     * Fetch PHP errors.
     *
     * @return array
     */
    public function engineErrors()
    {
        return $this->php_errors_container;
    }

    /**
     * Utilised memory (in KB).
     *
     * @return string
     */
    public function getUtilisedMemory()
    {
        return round(memory_get_peak_usage() / 1024);
    }
}
