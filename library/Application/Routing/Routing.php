<?php
namespace Application\Routing;

use Application\Application;
use Application\FileManager\FileManager;
use Application\Exception\ExceptionRuntime;
use Application\View\Forbidden;

class Routing
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
    * Routes file
    * 
    * @var string
    */
    private $routes_file;

    /**
    * Parsed JSON
    * 
    * @var string
    */
    private $routes_json;

    /**
    * Request from client
    * 
    * @var string
    */
    private $_request;

    /**
    * Construct
    *
    * @throws Application\Exception\ExceptionRuntime
    * @return void
    */
    public function __construct(Application $application)
    {
        // Load JSON file
        $this->routes_source = (new FileManager)->getContentsFromFile(Application::makePath('library:Application:Routing:Resources:Routes.json'));

        // Application object
        $this->application = $application;

        // JSON file not found
        if($this->routes_source === false) {
            throw new ExceptionRuntime('Error encountered while trying load routes file. Check whether this file exists on ++library/Application/Routing/Resources/Routes.json+-+');
        }

        // Parse JSON
        $this->routes_json = json_decode($this->routes_source, true);

        if($this->routes_json == null) {
            throw new ExceptionRuntime('Something goes wrong with routes file.');
        }
        
        // Client request
        $this->_request = '/' . getenv('QUERY_STRING');

        // Check routes
        if(count($this->routes_json['routes']) == 0) {
            return false;
        }

        // Loop
        foreach($this->routes_json['routes'] as $route_name => $route_data) {
            $this->_route[$route_name] = $route_data;
        }

        // Start routing
        $this->patternStart($application);
    }

    /**
    * Pattern Start
    *
    * @param Application $application
    * @throws Application\Exception\ExceptionRuntime
    * @return void
    */
    private function patternStart(Application $application)
    {
        // Loop
        foreach($this->_route as $node => $data) {
            // Pattern static
            if(isset($data['static']) && $data['static'] === true) {
                if($node === $this->_request || $node . '/' === $this->_request) {
                    // Controller is not defined
                    if(isset($data['controller']) === false || empty($data['controller']) ||
                        isset($data['action']) === false || empty($data['action'])
                    ) {
                        throw new ExceptionRuntime(sprintf('Controller or action in route: ++%s+-+ is not defined', $node));
                    }

                    // Controller not found
                    if(method_exists($data['controller'], $data['action'] . 'Action') === false) {
                        throw new ExceptionRuntime('++' . $data['controller'] . '::' . $data['action'] . 'Action()+-+ doesn\'t exists');
                    }

                    $controller = new $data['controller']($this->application);

                    // Call the controller
                    call_user_func([$controller, $data['action'] . 'Action']);

                    return false;
                }
            // Pattern match
            } else {
                if(isset($data['requirements']) && $data['requirements'] > 0) {
                    // Loop
                    foreach($data['requirements'] as $args => $regex) {
                        $node = str_replace('{' . $args . '}', '(?P<' . $args . '>' . $regex . ')', $node);
                    }
                } else {
                    throw new ExceptionRuntime('Requirements in regex-type routes must be defined');
                }

                $node = str_replace('/', '\/', $node);

                if(preg_match('/^' . $node . '\/?$/', $this->_request, $arguments)) {
                    // Controller is not defined
                    if(isset($data['controller']) === false || empty($data['controller']) ||
                        isset($data['action']) === false || empty($data['action'])
                    ) {
                        throw new ExceptionRuntime(sprintf('Controller or action in route: ++%s+-+ is not defined', $node));
                    }

                    // Controller not found
                    if(method_exists($data['controller'], $data['action'] . 'Action') === false) {
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
        (new Forbidden($application))->response404($this->_request, $this->fetchAllRoutes());
    }

    /**
    * Storage routes
    *  
    * @return array
    */
    public function fetchAllRoutes()
    {
        foreach($this->_route as $route => $data) {
            $_container[] = [
                'route_data' => $data, 
                'route_name' => $route
            ];
        }

        return $_container;
    }
}
