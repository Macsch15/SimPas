<?php
namespace Application\Pastebin;

use Application\Application;
use Application\View\View;
use Application\Configuration\Configuration;
use Application\Pastebin\ReadPaste;
use Application\Security\QuestionsAndAnswers\QuestionsAndAnswers;

class ReportAbuse extends View
{
    use Configuration;

    /**
    * Application
    * 
    * @var
    */
    private $application;

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
    * Report Abuse
    *
    * @param array $request
    * @return void
    */
    public function indexAction(array $request)
    {
        if((new ReadPaste($this->application))->pasteExists($request['id']) === false) {
            return $this->sendFriendlyClientError(_('Requested paste doesn\'t exists.'), true);
        }
        
        // Template render
        $this->render([
            'paste_id' => $request['id'],
            'antispam' => new QuestionsAndAnswers()
        ]);

        return $this->{'AbuseForm'};
    }

    /**
    * Send action
    * 
    * @return void
    */
    public function resultsAction()
    {

    }
}
