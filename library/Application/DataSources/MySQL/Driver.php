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
        // try-catch
        try {
            if($this->isConnected() === false) {
                // Try PDO connect
                $this->pdo = new PDO(
                    sprintf('mysql:host=%s;port=%d;dbname=%s' . ($this->config('Database')->dsn !== null ? ';' . $this->config('Database')->dsn : null), $this->config('Database')->server, $this->config('Database')->port, $this->config('Database')->database),
                    $this->config('Database')->username, $this->config('Database')->password
                );

                // Set attributes
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $this->is_connected = true;
            }
        } catch(PDOException $exception) {
            throw new ExceptionRuntime($exception->getMessage());
        }
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
