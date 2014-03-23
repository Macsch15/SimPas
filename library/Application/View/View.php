<?php
namespace Application\View;

use Application\Application;
use Application\Configuration\Configuration;
use Application\View\Exception;
use Application\HttpRequest\HttpRequest;
use Twig_Autoloader;
use Twig_Loader_Filesystem;
use Twig_Environment;
use Twig_SimpleFunction;
use Twig_Extensions_Extension_I18n;
use DirectoryIterator;

class View extends Exception
{
    use Configuration;

    /**
     * Twig Enviorment
     *  
     * @var object
     */
    private $_twig;

    /**
     * Twig Loader
     *  
     * @var object
     */
    private $loader;

    /**
     * Render
     * 
     * @var array
     */
    private $_render = [];

    /**
     * Twig integration
     * 
     * @param Application $application
     * @return void
     */
    public function __construct(Application $application)
    {
        // Register Twig
        Twig_Autoloader::register();

        $this->loader = new Twig_Loader_Filesystem(__DIR__ . DIRECTORY_SEPARATOR . 'Templates');

        // Setup Twig Enviorment
        $this->_twig = new Twig_Environment($this->loader, [
                'cache'            => (Application::TEMPLATE_CACHE === true ? Application::makePath('storage:templates') : false),
                'auto_reload'      => (Application::ENVIORMENT === 'dev' ?: false),
                'strict_variables' => (Application::ENVIORMENT === 'dev' ?: false)
        ]);

        // Add globals and functions
        $this->_twig->addGlobal('app', $application);
        $this->_twig->addGlobal('config', $this->config());

        // Add translations extension
        $this->_twig->addExtension(new Twig_Extensions_Extension_I18n());

        // Assets function
        $_this = $this; // Hello stupid closures.
        $this->_twig->addFunction(new Twig_SimpleFunction('assets', function ($folder, $entity) use ($_this) {
            return $_this->assets($folder, $entity);
        }));
    }

    /**
     * Prepare elements to render
     * 
     * @param array $display
     * @return array
     */
    public function render(array $display)
    {
        return $this->_render = $display;
    }

    /**
    * View accessor
    * 
    * @return Twig_Environment object
    */
    public function view()
    {
        return $this->_twig;
    }

    /**
    * List of template names
    * 
    * @return array
    */
    public function getTemplatesList()
    {
        foreach($this->loader->getPaths() as $_path) {
            foreach(new DirectoryIterator($_path) as $template_name) {
                // Ignore dots and non-template files
                if($template_name->isDot() || substr($template_name->getFileName(), -5) !== '.twig') {
                    continue;
                }

                $_templates[] = $template_name->getFileName();
            }            
        }

        return $_templates;
    }

    /**
     * Twig enviorment accessor
     *
     * @param string $template_name
     * @return Twig_Environment object
     */
    public function twig($template_name)
    {
        return $this->view()->loadTemplate($template_name);
    }

    /**
     * Magic __get
     * 
     * @param string $template_name 
     * @return void
     */
    public function __get($template_name)
    {
        // Site is offline
        if($this->clientHasNoPermissionsToDisplayPage() === true) {
            return $this->twig('SiteOffline.html.twig')->display([]);
        }

        // GZIP Compression
        if($this->config()->gzip_compression === true && extension_loaded('zlib')) {
            // Start GZIP compression
            ob_start('ob_gzhandler');

            // Content
            $this->twig($template_name . '.html.twig')->display($this->_render);

            // Close connection
            header('Connection: close');

            // Flush
            ob_end_flush();

            return true;
        }

        return $this->twig($template_name . '.html.twig')->display($this->_render);
    }

    /**
    * Check whether client has perrmisions to display page
    *  
    * @return bool
    */
    private function clientHasNoPermissionsToDisplayPage()
    {
        if($this->config()->site_offline === true 
            && $this->config()->offline_allow_ip !== HttpRequest::getClientIpAddress()
        ) {
            return true;
        } 

        return false;
    }

    /**
    * Client error
    * 
    * @param string $message
    * @return void
    */
    public function sendFriendlyClientError($message, $not_found_header = false)
    {
        if($not_found_header === true) {
            // Set headers
            header('HTTP/1.1 404 Not Found', true, 404);
        }

        return $this->twig('ClientError.html.twig')->display([
            'error_message' => $message
        ]);
    }

    /**
    * Regenerate template cache
    * 
    * @param bool $debug
    * @return bool|array
    */
    public function regenerateTemplateCache($debug = false)
    {
        foreach($this->getTemplatesList() as $_template) {
            // Create cache
            $this->twig($_template);

            // Debug
            if($debug === true) {
                $created_cache[] = $_template;
            }
        }

        if($debug === true) {
            return $created_cache;
        }

        return true;
    }

    /**
     * Full URL to static elements
     * 
     * @param string $folder
     * @param string $entity
     * @return string
     */
    public function assets($folder, $entity)
    {
        return $this->config()->full_url . 'assets/' . $this->config()->theme . '/' . $folder . '/' . $entity;
    }
}
