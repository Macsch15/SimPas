<?php

namespace SimPas\Pastebin;

use SimPas\Application;
use SimPas\Configuration\Configuration;
use SimPas\HttpRequest\CookieJar\CookieJar;

class Hits
{
    use Configuration;

    private $application;
    private $data_source;

    /**
     * Hits constructor.
     * @param Application $application
     * @throws \SimPas\Exception\ExceptionRuntime
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
        $this->data_source = $this->application->dbConnectionAccessor();
    }

    /**
     * @param $paste_id
     * @return bool
     */
    public function update($paste_id): bool
    {
        (new CookieJar())->set('paste_hits', md5($paste_id));

        if ((new CookieJar())->get('paste_hits') === md5($paste_id)) {
            return false;
        }

        $query = $this->data_source
            ->get()
            ->prepare('UPDATE ' . $this->config('database')['prefix'] . 'pastes SET hits = hits + 1 WHERE unique_id = :paste_id');

        $query->bindValue(':paste_id', $paste_id, constant('PDO::PARAM_INT'));
        $query->execute();

        return true;
    }
}
