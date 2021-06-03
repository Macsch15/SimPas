<?php

namespace SimPas\DataSources\MySQL;

use SimPas\Application;
use SimPas\Configuration\Configuration;
use SimPas\Exception\ExceptionRuntime;
use SimPas\FileManager\FileManager;
use PDO;
use PDOException;

class Driver
{
    use Configuration;

    /**
     * PDO.
     *
     * @var object
     */
    private $pdo;

    /**
     * Connect.
     *
     * @return void
     * @throws ExceptionRuntime
     *
     */
    public function __construct()
    {
        try {
            $this->pdo = new PDO(
                sprintf('mysql:host=%s;port=%d;dbname=%s', $this->config('database')['server'], $this->config('database')['port'], $this->config('database')['database']),
                $this->config('database')['username'],
                $this->config('database')['password']
            );

            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            throw new ExceptionRuntime($exception->getMessage());
        }
    }

    /**
     * Database accessor.
     *
     * @return PDO object
     */
    public function get()
    {
        return $this->pdo;
    }

    /**
     * Schema.
     *
     * @return bool|array
     */
    public function getSchema()
    {
        $schema_file = (new FileManager())->getContentsFromFile(Application::makePath('library:Application:DataSources:MySQL:Schema:Schema.json'));
        $schema_file = json_decode($schema_file, true);

        if ($schema_file === null) {
            return false;
        }

        return $schema_file;
    }
}
