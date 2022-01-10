<?php

namespace SimPas\Pastebin;

use SimPas\Application;
use SimPas\Configuration\Configuration;
use SimPas\View\View;

class LatestPastes extends View
{
    use Configuration;

    private $application;
    private $data_source;

    /**
     * LatestPastes constructor.
     * @param Application $application
     * @throws \SimPas\Exception\ExceptionRuntime
     */
    public function __construct(Application $application)
    {
        parent::__construct($application);

        $this->application = $application;
        $this->data_source = $this->application->dbConnectionAccessor();
    }

    /**
     * @return bool
     * @throws \SimPas\Exception\ExceptionRuntime
     */
    public function indexAction()
    {
        $this->render([
            'container' => $this->publicPastesContainer(),
            'paste_expire' => new PasteExpire($this->application),
        ]);

        return $this->{'LatestPastes'};
    }

    /**
     * @return array
     */
    private function publicPastesContainer(): array
    {
        $query = $this->data_source
            ->get()
            ->prepare('SELECT unique_id, time, syntax, title, author, visibility, author_website, expire, hits
            FROM ' . $this->config('database')['prefix'] . 'pastes WHERE visibility = :visibility ORDER BY time DESC LIMIT :limit');

        $query->bindValue(':limit', $this->config()['latest_pastes'], constant('PDO::PARAM_INT'));
        $query->bindValue(':visibility', 'public');
        $query->execute();

        return $query->fetchAll();
    }
}
