<?php

namespace SimPas\Pastebin;

use SimPas\Application;
use SimPas\Configuration\Configuration;

class ReadPaste
{
    use Configuration;

    private $data_source;

    /**
     * ReadPaste constructor.
     * @param Application $application
     * @throws \SimPas\Exception\ExceptionRuntime
     */
    public function __construct(Application $application)
    {
        $this->data_source = $application->dbConnectionAccessor();
    }

    /**
     * @param $paste_id
     * @return mixed
     */
    public function read($paste_id)
    {
        $query = $this->data_source
            ->get()
            ->prepare('SELECT 
            unique_id, 
            time, size, 
            length, 
            syntax, 
            content, 
            ip_address,
            raw_content, 
            title, 
            author, 
            start_from_line, 
            visibility, 
            author_website,
            expire,
            hits
        FROM ' . $this->config('database')['prefix'] . 'pastes WHERE unique_id = :paste_id LIMIT 1');

        $query->bindValue(':paste_id', $paste_id, constant('PDO::PARAM_INT'));
        $query->execute();

        return $query->fetchAll()[0];
    }

    /**
     * @param $paste_id
     * @return bool
     */
    public function pasteExists($paste_id): bool
    {
        $query = $this->data_source
            ->get()
            ->prepare('SELECT unique_id FROM ' . $this->config('database')['prefix'] . 'pastes WHERE unique_id = :paste_id');

        $query->bindValue(':paste_id', $paste_id, constant('PDO::PARAM_INT'));
        $query->execute();

        $rows = $query->fetchAll();

        if (is_array($rows) && count($rows)) {
            return true;
        }

        return false;
    }
}
