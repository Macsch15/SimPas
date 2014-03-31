<?php
namespace Application\Pastebin;

use Application\Application;
use Application\View\View;
use Application\Configuration\Configuration;

class LatestPastes extends View
{
    use Configuration;
    
    /**
    * Construct
    * 
    * @param Application $application
    * @return void
    */
    public function __construct(Application $application)
    {
        parent::__construct($application);

        $this->application = $application;
        $this->data_source = $this->application->dbConnectionAccessor();
    }

    /**
    * Latest pastes
    *
    * @return void
    */
    public function indexAction()
    {
        // Template render
        $this->render([
            'container' => $this->publicPastesContainer()
        ]);

        return $this->{'LatestPastes'};
    }

    /**
    * Public pastes container
    * 
    * @return array
    */
    private function publicPastesContainer()
    {
        // Prepare query
        $query = $this->data_source
        ->get()
        ->prepare('SELECT unique_id, time, syntax, title, author, visibility
            FROM ' . $this->config('Database')->prefix  . 'pastes WHERE visibility = "public" ORDER BY time DESC LIMIT :limit');

        // Filter
        $query->bindValue(':limit', $this->config()->latest_pastes, constant('PDO::PARAM_INT'));

        // Execute
        $query->execute();

        return $query->fetchAll();
    }
}
