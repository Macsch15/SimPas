<?php
namespace Application\Pastebin;

use Application\Application;
use Application\Configuration\Configuration;

class ReadPaste
{
    use Configuration;

    /**
    * DataBase
    * 
    * @var object
    */
    private $data_source;

    /**
    * Construct
    *
    * @param Application $application
    * @return void
    */
    public function __construct(Application $application)
    {
        $this->data_source = $application->dbConnectionAccessor();
    }

    /**
    * Read paste data from data source
    * 
    * @param type 
    * @return array
    */
    public function read($paste_id)
    {
        // Prepare query
        $query = $this->data_source
        ->get()
        ->prepare('SELECT * FROM ' . $this->config('Database')->prefix  . 'pastes WHERE unique_id = :paste_id LIMIT 1');

        // Filter
        $query->bindValue(':paste_id', $paste_id, constant('PDO::PARAM_INT'));

        // Execute
        $query->execute();

        return $query->fetchAll()[0];
    }
}
