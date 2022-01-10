<?php

namespace SimPas\View;

use SimPas\Application;
use SimPas\Configuration\Configuration;
use SimPas\HttpRequest\HttpRequest;
use DirectoryIterator;
use Twig_Environment;
use Twig_Extensions_Extension_I18n;
use Twig_Loader_Filesystem;
use Twig_SimpleFunction;

class View extends Exception
{
    use Configuration;

    private $twig;
    private $loader;
    private $render = [];

    /**
     * View constructor.
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->loader = new Twig_Loader_Filesystem(Application::makePath('views'));

        $this->twig = new Twig_Environment($this->loader, [
            'cache' => (Application::TEMPLATE_CACHE === true ? Application::makePath('storage:templates') : false),
            'auto_reload' => (Application::ENVIRONMENT === 'dev'),
            'strict_variables' => (Application::ENVIRONMENT === 'dev'),
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
     * @param array $display
     * @return array
     */
    public function render(array $display)
    {
        return $this->render = $display;
    }

    /**
     * @return Twig_Environment
     */
    public function view()
    {
        return $this->twig;
    }

    /**
     * @return array
     */
    public function getTemplatesList(): array
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
     * @param $template_name
     * @return \Twig_TemplateInterface
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Syntax
     */
    public function twig($template_name)
    {
        return $this->view()->loadTemplate($template_name);
    }

    /**
     * @param $template_name
     * @return bool
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Syntax
     */
    public function __get($template_name)
    {
        if ($this->clientHasNoPermissionsToDisplayPage() === true) {
            return $this->twig('SiteOffline.html.twig')->display([]);
        }

        if ($this->config()['gzip_compression'] === true && extension_loaded('zlib')) {
            ob_start('ob_gzhandler');

            $this->twig($template_name . '.html.twig')->display($this->render);

            header('Connection: close');

            ob_end_flush();

            return true;
        }

        return $this->twig($template_name . '.html.twig')->display($this->render);
    }

    /**
     * @return bool
     */
    private function clientHasNoPermissionsToDisplayPage(): bool
    {
        if ($this->config()['site_offline'] === true
            && $this->config()['offline_allow_ip'] !== HttpRequest::getClientIpAddress()
        ) {
            return true;
        }

        return false;
    }

    /**
     * @param $message
     * @param false $not_found_header
     * @return mixed
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Syntax
     */
    public function sendFriendlyClientError($message, bool $not_found_header = false)
    {
        if ($not_found_header === true) {
            header('HTTP/1.1 404 Not Found', true, 404);
        }

        return $this->twig('ClientErrors/ClientError.html.twig')->display([
            'error_message' => $message,
        ]);
    }

    /**
     * @param false $debug
     * @return array|bool
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Syntax
     */
    public function regenerateTemplateCache(bool $debug = false)
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
     * @param $folder
     * @param $entity
     * @return string
     */
    public function assets($folder, $entity): string
    {
        return $this->config()['full_url'] . 'assets/' . $this->config()['theme'] . '/' . $folder . '/' . $entity;
    }
}
