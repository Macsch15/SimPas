<?php

namespace Application\Pastebin;

use Application\Application;
use Application\Configuration\Configuration;
use Application\View\View;

class LatestPastes extends View
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
        parent::__construct($application);

        $this->application = $application;
        $this->data_source = $this->application->dbConnectionAccessor();
    }

    /**
     * Latest pastes.
     *
     * @throws \Application\Exception\ExceptionRuntime
     *
     * @return void
     */
    public function indexAction()
    {
        $this->render([
            'container'    => $this->publicPastesContainer(),
            'paste_expire' => new PasteExpire($this->application),
        ]);

        return $this->{'LatestPastes'};
    }

    /**
     * Public pastes container.
     *
     * @return array
     */
    private function publicPastesContainer()
    {
        $query = $this->data_source
        ->get()
        ->prepare('SELECT unique_id, time, syntax, title, author, visibility, author_website, expire, hits
            FROM '.$this->config('database')['prefix'].'pastes WHERE visibility = :visibility ORDER BY time DESC LIMIT :limit');

        $query->bindValue(':limit', $this->config()['latest_pastes'], constant('PDO::PARAM_INT'));
        $query->bindValue(':visibility', 'public');
        $query->execute();

        return $query->fetchAll();
    }
}
