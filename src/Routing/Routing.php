<?php

namespace SimPas\Routing;

use SimPas\Application;
use SimPas\Exception\AssetNotFound;
use SimPas\Exception\ExceptionRuntime;
use SimPas\View\ClientError;
use SimPas\View\View;

class Routing extends View
{
    private $_route;
    private $application;
    private $_request;

    /**
     * Routing constructor.
     * @param Application $application
     * @throws AssetNotFound
     * @throws ExceptionRuntime
     */
    public function __construct(Application $application)
    {
        parent::__construct($application);

        $routesPath = Application::makePath('routes:routes.php');

        if (file_exists($routesPath) === false) {
            throw new AssetNotFound('Error encountered while trying load routes file.');
        }

        $this->application = $application;

        $routes = array_merge(require $routesPath);

        $this->_request = '/' . getenv('QUERY_STRING');

        foreach ($routes['routes'] as $route_name => $route_data) {
            $this->_route[$route_name] = $route_data;
        }

        $this->patternStart($application);
    }

    /**
     * @param Application $application
     * @return bool
     * @throws ExceptionRuntime
     */
    private function patternStart(Application $application)
    {
        foreach ($this->_route as $node => $data) {
            if (isset($data['static']) && $data['static'] === true) {
                if ($node === $this->_request || $node . '/' === $this->_request) {
                    if (isset($data['template'])) {
                        return $this->{$data['template']};
                    }

                    if (isset($data['controller']) === false || empty($data['controller']) ||
                        isset($data['action']) === false || empty($data['action'])
                    ) {
                        throw new ExceptionRuntime(sprintf('Controller or action in route: ++%s+-+ is not defined', $node));
                    }

                    if (method_exists($data['controller'], $data['action'] . 'Action') === false) {
                        throw new ExceptionRuntime('++' . $data['controller'] . '::' . $data['action'] . 'Action()+-+ doesn\'t exists');
                    }

                    $controller = new $data['controller']($this->application);

                    call_user_func([$controller, $data['action'] . 'Action'], []);

                    return false;
                }
            } else {
                if (isset($data['requirements']) && $data['requirements'] > 0) {
                    foreach ($data['requirements'] as $args => $regex) {
                        $node = str_replace('{' . $args . '}', '(?P<' . $args . '>' . $regex . ')', $node);
                    }
                } else {
                    throw new ExceptionRuntime('Requirements in regex-type routes must be defined');
                }

                $node = str_replace('/', '\/', $node);

                if (preg_match('/^' . $node . '\/?(.*?)$/', $this->_request, $arguments)) {
                    if (isset($data['controller']) === false || empty($data['controller']) ||
                        isset($data['action']) === false || empty($data['action'])
                    ) {
                        throw new ExceptionRuntime(sprintf('Controller or action in route: ++%s+-+ is not defined', $node));
                    }

                    if (method_exists($data['controller'], $data['action'] . 'Action') === false) {
                        throw new ExceptionRuntime('++' . $data['controller'] . '::' . $data['action'] . 'Action()+-+ doesn\'t exists');
                    }

                    $controller = new $data['controller']($this->application);

                    call_user_func([$controller, $data['action'] . 'Action'], $arguments);

                    return false;
                }
            }
        }

        (new ClientError($application))->response404();
    }
}
