<?php
namespace Application\DataSources\MySQL;

use Application\Application;
use Application\Exception\ExceptionRuntime;
use Application\Exception\ExceptionInvalidArgument;
use Application\Configuration\Configuration;
use Application\FileManager\FileManager;
use PDO;
use PDOException;

class Driver
{
    use Configuration;

    /**
     * Data
     *
     * @var array
     */
    public $data = [];

    /**
     * Is connected
     *
     * @var boolean
     */
    private $is_connected = false;

    /**
     * PDO
     *
     * @var object
     */
    private $pdo;

    /**
     * Connect
     *
     * @throws Application\Exception\ExceptionRuntime
     * @return void
     */
    public function __construct()
    {
        // Database data
        // REMOVEEEEEEEEEEEEEEEEEEEEE
        $this->data['server']   = $this->config('Database')->server;
        $this->data['port']     = $this->config('Database')->port;
        $this->data['database'] = $this->config('Database')->database;
        $this->data['username'] = $this->config('Database')->username;
        $this->data['password'] = $this->config('Database')->password;
        $this->data['dsn']      = ($this->config('Database')->dsn !== null ? ';' . $this->config('Database')->dsn : null);

        // try-catch
        try {
            if($this->isConnected() === false) {
                // Try PDO connect
                $this->pdo = new PDO(
                    sprintf('mysql:host=%s;port=%d;dbname=%s' . $this->data['dsn'], $this->data['server'], $this->data['port'], $this->data['database']),
                    $this->data['username'], $this->data['password']
                );

                // Set attributes
                $this->attributes([
                    'ERRMODE' => (Application::ENVIORMENT === 'dev') ? 'ERRMODE_EXCEPTION' : 'ERRMODE_SILENT'
                ]);

                $this->is_connected = true;
            }
        } catch(PDOException $exception) {
            throw new ExceptionRuntime($exception->getMessage());
        }

        // Clean
        unset($this->data);
    }

    /**
     * Disconnect
     *
     * @return void
     */
    public function disconnect()
    {
        $this->pdo = null;
        $this->is_connected = false;
    }

    /**
     * Is connected
     * 
     * @return boolean
     */
    public function isConnected()
    {
        return $this->is_connected;
    }

    /**
     * Attributes
     *
     * @param array $data
     * @param string $type
     * @throws Application\Exception\ExceptionInvalidArgument
     * @return array
     */
    public function attributes(array $data = [], $type = 'SET')
    {
        $list = [
            'ATTR_AUTOCOMMIT', 'ATTR_CASE', 'ATTR_CLIENT_VERSION', 'ATTR_CONNECTION_STATUS', 'ATTR_DRIVER_NAME', 'ATTR_ERRMODE', 'ATTR_ORACLE_NULLS',
            'ATTR_PERSISTENT', 'ATTR_PREFETCH', 'ATTR_SERVER_INFO', 'ATTR_SERVER_VERSION', 'ATTR_TIMEOUT', 'ATTR_EMULATE_PREPARES'
        ];

        // Attribute is not defined
        if(!count($data)) {
            throw new ExceptionInvalidArgument('No attributes detected');
        }

        switch(strtoupper($type)) {
            case 'GET':
                foreach($data as $value) {
                    $value = strtoupper($value);

                    // Add prefix
                    if(substr($value, 0, 5) !== 'ATTR_') {
                        $value = 'ATTR_' . $value;
                    }

                    // Attribute is not defined
                    if(!in_array($value, $list)) {
                        throw new ExceptionInvalidArgument('Undefined attribute. List of avaiable attribites: ' . implode(', ', $list));
                    }       

                    $result[$value] = $this->pdo->getAttribute(constant('PDO::' . $value));
                }

                return $result;
            break;  
            case 'SET':
            default:
                foreach($data as $name => $value) {
                    $name = strtoupper($name);

                    // Add prefix
                    if(substr($name, 0, 5) !== 'ATTR_') {
                        $name = 'ATTR_' . $name;
                    }                    

                    // Attribute is not defined
                    if(in_array($name, $list) === false) {
                        throw new ExceptionInvalidArgument('Undefined attribute. List of avaiable attribites: ' . implode(', ', $list));
                    }
                    
                    $this->pdo->setAttribute(constant('PDO::' . $name), constant('PDO::' . $value));
                }
            break;
        }
    }

    /**
     * Database accessor
     *
     * @return PDO object
     */
    public function get()
    {
        return $this->pdo;
    }

    /**
    * Schema
    * 
    * @return array
    */
    public function getSchema()
    {
        // Load and decode JSON schema
        $schema_file = (new FileManager)->getContentsFromFile(Application::makePath('library:Application:DataSources:MySQL:Schema:Schema.json'));
        $schema_file = json_decode($schema_file, true);

        // Test
        if($schema_file === null) {
            return false;
        }

        return $schema_file;
    }
}
