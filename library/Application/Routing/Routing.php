<?php
namespace Application\Routing;

use Application\Application;
use Application\Exception\AssetNotFound;
use Application\Exception\ExceptionRuntime;
use Application\Exception\JsonException;
use Application\FileManager\FileManager;
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
     * @var bool|string
     */
    private $routes_source;

    /**
     * Construct
     *
     * @param Application $application
     * @throws AssetNotFound
     * @throws JsonException
     */
    public function __construct(Application $application)
    {
        parent::__construct($application);

        // Load JSON file
        $this->routes_source = (new FileManager)->getContentsFromFile(Application::makePath('library:Application:Routing:Resources:Routes.json'));

        // Application object
        $this->application = $application;

        // JSON file not found
        if($this->routes_source === false) {
            throw new AssetNotFound('Error encountered while trying load routes file. Check whether this file exists on ++library/Application/Routing/Resources/Routes.json+-+');
        }

        // Parse JSON
        $this->routes_json = json_decode($this->routes_source, true);

        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                $error_message = false;
                break;
            case JSON_ERROR_DEPTH:
                $error_message = 'Maximum stack depth exceeded';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $error_message = 'Underflow or the modes mismatch';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $error_message = 'Unexpected control character found';
                break;
            case JSON_ERROR_SYNTAX:
                $error_message = 'Syntax error, malformed JSON';
                break;
            case JSON_ERROR_UTF8:
                $error_message = 'Malformed UTF-8 characters, possibly incorrectly encoded';
                break;
            default:
                $error_message = 'Unknown error';
                break;
        }

        if($error_message !== false) {
            throw new JsonException('JSON Error: ' . $error_message . ' in Routes.json');
        }
        
        // Client request
        $this->_request = '/' . getenv('QUERY_STRING');

        // Check routes
        if (count($this->routes_json['routes']) == 0) {
            return false;
        }

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
     * @return bool
     * @throws ExceptionRuntime
     * @throws Application\Exception\ExceptionRuntime
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

                if (preg_match('/^' . $node . '\/?$/', $this->_request, $arguments)) {
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
