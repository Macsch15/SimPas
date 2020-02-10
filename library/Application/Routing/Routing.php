<?php
namespace Application\Routing;

use Application\Application;
use Application\Exception\AssetNotFound;
use Application\Exception\ExceptionRuntime;
use Application\View\ClientError;
use Application\View\View;

class Routing extends View
{
    /**
     * Routes
     * 
     * @var array
    */
    private $_route;

    /**
     * Application
     * 
     * @var object
     */
    private $application;

    /**
     * Request from client
     * 
     * @var string
     */
    private $_request;

    /**
     * Construct
     *
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

        // Application object
        $this->application = $application;

        $routes = array_merge(require $routesPath);

        // Client request
        $this->_request = '/' . getenv('QUERY_STRING');

        // Check routes
        if (count($routes['routes']) === 0) {
            return false;
        }

        foreach($routes['routes'] as $route_name => $route_data) {
            $this->_route[$route_name] = $route_data;
        }

        // Start routing
        $this->patternStart($application);
    }

    /**
     * Pattern Start
     *
     * @param Application $application
     * @return bool
     * @throws ExceptionRuntime
     * @throws \Application\Exception\ExceptionRuntime
     */
    private function patternStart(Application $application)
    {
        foreach($this->_route as $node => $data) {
            // Pattern static
            if (isset($data['static']) && $data['static'] === true) {
                if($node === $this->_request || $node . '/' === $this->_request) {
                    // Controller is not needed. Start parse template
                    if (isset($data['template'])) {
                        return $this->{$data['template']};
                    }

                    // Controller is not defined
                    if (isset($data['controller']) === false || empty($data['controller']) ||
                        isset($data['action']) === false || empty($data['action'])
                    ) {
                        throw new ExceptionRuntime(sprintf('Controller or action in route: ++%s+-+ is not defined', $node));
                    }

                    // Controller not found
                    if (method_exists($data['controller'], $data['action'] . 'Action') === false) {
                        throw new ExceptionRuntime('++' . $data['controller'] . '::' . $data['action'] . 'Action()+-+ doesn\'t exists');
                    }

                    $controller = new $data['controller']($this->application);

                    // Call the controller
                    call_user_func([$controller, $data['action'] . 'Action'], []);

                    return false;
                }
            // Pattern match
            } else {
                if (isset($data['requirements']) && $data['requirements'] > 0) {
                    foreach($data['requirements'] as $args => $regex) {
                        $node = str_replace('{' . $args . '}', '(?P<' . $args . '>' . $regex . ')', $node);
                    }
                } else {
                    throw new ExceptionRuntime('Requirements in regex-type routes must be defined');
                }

                $node = str_replace('/', '\/', $node);

                if (preg_match('/^' . $node . '\/?(.*?)$/', $this->_request, $arguments)) {
                    // Controller is not defined
                    if (isset($data['controller']) === false || empty($data['controller']) ||
                        isset($data['action']) === false || empty($data['action'])
                    ) {
                        throw new ExceptionRuntime(sprintf('Controller or action in route: ++%s+-+ is not defined', $node));
                    }

                    // Controller not found
                    if (method_exists($data['controller'], $data['action'] . 'Action') === false) {
                        throw new ExceptionRuntime('++' . $data['controller'] . '::' . $data['action'] . 'Action()+-+ doesn\'t exists');
                    }

                    $controller = new $data['controller']($this->application);

                    // Call the controller
                    call_user_func([$controller, $data['action'] . 'Action'], $arguments);

                    return false;
                }
            }
        }

        // Forbidden
        (new ClientError($application))->response404();
    }
}
