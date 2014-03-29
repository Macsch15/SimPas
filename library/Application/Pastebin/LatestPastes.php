<?php
namespace Application\Pastebin;

use Application\Application;
use Application\View\View;

class LatestPastes extends View
{
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
        return $this->{'LatestPastes'};
    }
}
