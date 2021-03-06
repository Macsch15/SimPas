<?php

namespace Application\View;

use Application\Application;
use Application\Configuration\Configuration;
use Application\HttpRequest\HttpRequest;
use DirectoryIterator;
use Twig_Environment;
use Twig_Extensions_Extension_I18n;
use Twig_Loader_Filesystem;
use Twig_SimpleFunction;

class View extends Exception
{
    use Configuration;

    /**
     * Twig Environment.
     *
     * @var object
     */
    private $twig;

    /**
     * Twig Loader.
     *
     * @var object
     */
    private $loader;

    /**
     * Render.
     *
     * @var array
     */
    private $render = [];

    /**
     * Twig integration.
     *
     * @param Application $application
     *
     * @return void
     */
    public function __construct(Application $application)
    {
        $this->loader = new Twig_Loader_Filesystem(Application::makePath('views'));

        $this->twig = new Twig_Environment($this->loader, [
            'cache'            => (Application::TEMPLATE_CACHE === true ? Application::makePath('storage:templates') : false),
            'auto_reload'      => (Application::ENVIRONMENT === 'dev' ?: false),
            'strict_variables' => (Application::ENVIRONMENT === 'dev' ?: false),
        ]);

        $this->twig->addGlobal('app', $application);
        $this->twig->addGlobal('config', $this->config());

        $this->twig->addExtension(new Twig_Extensions_Extension_I18n());

        $this->twig->addFunction(new Twig_SimpleFunction('assets', function ($folder, $entity) {
            return $this->assets($folder, $entity);
        }));

        $this->twig->addFunction(new Twig_SimpleFunction('build_url', function ($route = null) use ($application) {
            return $application->buildUrl($route);
        }));
    }

    /**
     * Prepare elements to render.
     *
     * @param array $display
     *
     * @return array
     */
    public function render(array $display)
    {
        return $this->render = $display;
    }

    /**
     * View accessor.
     *
     * @return Twig_Environment object
     */
    public function view()
    {
        return $this->twig;
    }

    /**
     * List of template names.
     *
     * @return array
     */
    public function getTemplatesList()
    {
        $_templates = [];

        foreach ($this->loader->getPaths() as $_path) {
            foreach (new DirectoryIterator($_path) as $template_name) {
                if ($template_name->isDot() || substr($template_name->getFileName(), -5) !== '.twig') {
                    continue;
                }

                $_templates[] = $template_name->getFileName();
            }
        }

        return $_templates;
    }

    /**
     * Twig environment accessor.
     *
     * @param string $template_name
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Syntax
     *
     * @return \Twig_TemplateInterface
     */
    public function twig($template_name)
    {
        return $this->view()->loadTemplate($template_name);
    }

    /**
     * Magic __get.
     *
     * @param string $template_name
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Syntax
     *
     * @return bool
     */
    public function __get($template_name)
    {
        if ($this->clientHasNoPermissionsToDisplayPage() === true) {
            return $this->twig('SiteOffline.html.twig')->display([]);
        }

        if ($this->config()['gzip_compression'] === true && extension_loaded('zlib')) {
            ob_start('ob_gzhandler');

            $this->twig($template_name.'.html.twig')->display($this->render);

            header('Connection: close');

            ob_end_flush();

            return true;
        }

        return $this->twig($template_name.'.html.twig')->display($this->render);
    }

    /**
     * Check whether client has perrmisions to display page.
     *
     * @return bool
     */
    private function clientHasNoPermissionsToDisplayPage()
    {
        if ($this->config()['site_offline'] === true
            && $this->config()['offline_allow_ip'] !== HttpRequest::getClientIpAddress()
        ) {
            return true;
        }

        return false;
    }

    /**
     * Client error.
     *
     * @param string $message
     * @param bool   $not_found_header
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Syntax
     *
     * @return void
     */
    public function sendFriendlyClientError($message, $not_found_header = false)
    {
        if ($not_found_header === true) {
            header('HTTP/1.1 404 Not Found', true, 404);
        }

        return $this->twig('ClientErrors/ClientError.html.twig')->display([
            'error_message' => $message,
        ]);
    }

    /**
     * Regenerate template cache.
     *
     * @param bool $debug
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Syntax
     *
     * @return bool|array
     */
    public function regenerateTemplateCache($debug = false)
    {
        $created_cache = [];

        foreach ($this->getTemplatesList() as $_template) {
            $this->twig($_template);

            if ($debug === true) {
                $created_cache[] = $_template;
            }
        }

        if ($debug === true) {
            return $created_cache;
        }

        return true;
    }

    /**
     * Full URL to static elements.
     *
     * @param string $folder
     * @param string $entity
     *
     * @return string
     */
    public function assets($folder, $entity)
    {
        return $this->config()['full_url'].'assets/'.$this->config()['theme'].'/'.$folder.'/'.$entity;
    }
}
