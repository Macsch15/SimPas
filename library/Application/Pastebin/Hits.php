<?php

namespace Application\Pastebin;

use Application\Application;
use Application\Configuration\Configuration;
use Application\HttpRequest\CookieJar\CookieJar;

class Hits
{
    use Configuration;

    /**
     * Application.
     *
     * @var object
     */
    private $application;

    /**
     * DataBase.
     *
     * @var object
     */
    private $data_source;

    /**
     * Construct.
     *
     * @param Application $application
     *
     * @throws \Application\Exception\ExceptionRuntime
     *
     * @return void
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
        $this->data_source = $this->application->dbConnectionAccessor();
    }

    /**
     * Update hit for specific paste.
     *
     * @param int $paste_id
     *
     * @return bool
     */
    public function update($paste_id)
    {
        (new CookieJar())->set('paste_hits', md5($paste_id));

        if ((new CookieJar())->get('paste_hits') === md5($paste_id)) {
            return false;
        }

        $query = $this->data_source
        ->get()
        ->prepare('UPDATE '.$this->config('database')['prefix'].'pastes SET hits = hits + 1 WHERE unique_id = :paste_id');

        $query->bindValue(':paste_id', $paste_id, constant('PDO::PARAM_INT'));
        $query->execute();
    }
}
