<?php
namespace Application\Pastebin;

use Application\Application;
use Application\View\View;
use Application\Configuration\Configuration;
use Application\HttpRequest\HttpRequest;
use Application\Pastebin\ReadPaste;
use Application\Security\QuestionsAndAnswers\QuestionsAndAnswers;
use Application\Mailer\Mailer;

class ReportAbuse extends View
{
    use Configuration;

    /**
     * Application
     * 
     * @var object
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
        // Paste exists?
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
     * @param array $request
     * @return void
     */
    public function resultsAction(array $request)
    {
        // Doesn't have admin email?
        if($this->config()->admin_email == null) {
            return $this->sendFriendlyClientError(_('Action are not allowed. Aborting.'), true);
        }

        // Paste exists?
        if((new ReadPaste($this->application))->pasteExists($request['id']) === false) {
            return $this->sendFriendlyClientError(_('Requested paste doesn\'t exists.'), true);
        }

        // Anti-spam
        if($this->config()->antispam_enabled === true && 
            (new QuestionsAndAnswers())->validate(HttpRequest::post('post_antispam_question'), 
                HttpRequest::post('post_antispam_answer')) === false || HttpRequest::post('post_antispam_answer') === false
        ) {
            return $this->sendFriendlyClientError(_('Wrong anti-spam answer. Refresh page and try again.'));
        }

        // Empty fields
        if (HttpRequest::post('post_paste_abuse_reason') === false || 
            HttpRequest::isEmptyField([HttpRequest::post('post_paste_abuse_reason')])
        ) {
            return $this->sendFriendlyClientError(_('Some field there are empty or contains prohibited characters (e.g only spaces).'));
        }

        $render_mail = $this->twig('EmailTemplates/Abuse.html.twig')->render([
            'paste_id' => $request['id'],
            'reason' => HttpRequest::post('post_paste_abuse_reason', 'html'),
            'ip_address' => HttpRequest::getClientIpAddress()
        ]);

        $message = (new Mailer)->message(sprintf(_('You have received abuse report at %s'), $this->config()->site_title))
        ->setFrom([$this->config()->admin_email => $this->config()->site_title])
        ->setTo($this->config()->admin_email)
        ->setBody($render_mail, 'text/html');

        $success = false;

        if((new Mailer)->mailer()->send($message)) {
            $success = true;
        }

        // Template render
        $this->render([
            'paste_id' => $request['id'],
            'success' => $success
        ]);

        return $this->{'AbuseFormResults'};
    }
}
