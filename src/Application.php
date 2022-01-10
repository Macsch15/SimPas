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

    private $php_errors_container;

    const ENVIRONMENT = 'dev';
    const TEMPLATE_CACHE = false;
    const VERSION = '0.8.0';
    const NAME = 'SimPas';

    /**
     * Application constructor.
     * @param array $cmd_argv
     * @throws \Exception
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
     * @param null $path
     * @return string
     */
    public static function makePath($path = null): string
    {
        $path = str_replace(':', DIRECTORY_SEPARATOR, $path);

        return __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $path;
    }

    /**
     * @param null $route
     * @return mixed|string
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
     * @return MysqlDriver|PostgresqlDriver
     */
    public function dbConnectionAccessor()
    {
        switch ($this->config('database')['driver']) {
            case 'mysql':
            default:
                return new MysqlDriver();
            case 'postgresql':
                return new PostgresqlDriver();
        }
    }

    /**
     * @param $errno
     * @param $errstr
     * @param $errfile
     * @param $errline
     */
    public function engineErrorsHandler($errno, $errstr, $errfile, $errline)
    {
        $this->php_errors_container[] = sprintf(_('%s on line %d in file %s'), $errstr, $errline, $errfile);
    }

    /**
     * @return mixed
     */
    public function engineErrors()
    {
        return $this->php_errors_container;
    }

    /**
     * @return float
     */
    public function getUtilisedMemory(): float
    {
        return round(memory_get_peak_usage() / 1024);
    }
}
