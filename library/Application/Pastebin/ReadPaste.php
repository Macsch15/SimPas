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
    * @param int $paste_id
    * @return array
    */
    public function read($paste_id)
    {
        // Prepare query
        $query = $this->data_source
        ->get()
        ->prepare('SELECT unique_id, time, size, length, syntax, content, ip_address, raw_content, title, author, start_from_line, visibility, author_website
            FROM ' . $this->config('Database')->prefix  . 'pastes WHERE unique_id = :paste_id LIMIT 1');

        // Filter
        $query->bindValue(':paste_id', $paste_id, constant('PDO::PARAM_INT'));

        // Execute
        $query->execute();

        return $query->fetchAll()[0];
    }

    /**
    * Paste exists
    * 
    * @param int $paste_id 
    * @return bool
    */
    public function pasteExists($paste_id)
    {
        // Prepare query
        $query = $this->data_source
        ->get()
        ->prepare('SELECT unique_id FROM ' . $this->config('Database')->prefix . 'pastes WHERE unique_id = :paste_id');

        // Filter and execute
        $query->bindValue(':paste_id', $paste_id, constant('PDO::PARAM_INT'));
        $query->execute();

        $rows = $query->fetchAll();

        // Test
        if(is_array($rows) && count($rows)) {
            return true;
        }

        return false;
    }
}
