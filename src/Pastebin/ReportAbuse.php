<?php

namespace SimPas\Pastebin;

use SimPas\Application;
use SimPas\Configuration\Configuration;
use SimPas\HttpRequest\HttpRequest;
use SimPas\Mailer\Mailer;
use SimPas\Security\QuestionsAndAnswers\QuestionsAndAnswers;
use SimPas\View\View;

class ReportAbuse extends View
{
    use Configuration;

    private $application;

    /**
     * ReportAbuse constructor.
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
     * @param array $request
     * @return bool|void
     * @throws \SimPas\Exception\ExceptionRuntime
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Syntax
     */
    public function indexAction(array $request)
    {
        if ((new ReadPaste($this->application))->pasteExists($request['id']) === false) {
            $this->sendFriendlyClientError(_('Requested paste doesn\'t exists.'), true);

            return false;
        }

        $this->render([
            'paste_id' => $request['id'],
            'antispam' => new QuestionsAndAnswers(),
        ]);

        return $this->{'AbuseForm'};
    }

    /**
     * @param array $request
     * @return bool|void
     * @throws \SimPas\Exception\ExceptionRuntime
     * @throws \SimPas\Exception\MailerException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Syntax
     */
    public function resultsAction(array $request)
    {
        if ($this->config()['admin_email'] == null) {
            $this->sendFriendlyClientError(_('Action are not allowed. Aborting.'), true);

            return false;
        }

        if ((new ReadPaste($this->application))->pasteExists($request['id']) === false) {
            $this->sendFriendlyClientError(_('Requested paste doesn\'t exists.'), true);

            return false;
        }

        if ($this->config()['antispam_enabled'] === true &&
            (new QuestionsAndAnswers())->validate(
                HttpRequest::post('post_antispam_question'),
                HttpRequest::post('post_antispam_answer')
            ) === false || HttpRequest::post('post_antispam_answer') === false
        ) {
            $this->sendFriendlyClientError(_('Wrong anti-spam answer. Refresh page and try again.'));

            return false;
        }

        if (HttpRequest::post('post_paste_abuse_reason') === false ||
            HttpRequest::isEmptyField([HttpRequest::post('post_paste_abuse_reason')])
        ) {
            $this->sendFriendlyClientError(_('Some field there are empty or contains prohibited characters (e.g only spaces).'));

            return false;
        }

        $render_mail = $this->twig('EmailTemplates/Abuse.html.twig')->render([
            'paste_id' => $request['id'],
            'reason' => HttpRequest::post('post_paste_abuse_reason', 'html'),
            'ip_address' => HttpRequest::getClientIpAddress(),
        ]);

        $message = (new Mailer())->message(sprintf(_('You have received abuse report at %s'), $this->config()['site_title']))
            ->setFrom([$this->config()['admin_email'] => $this->config()['site_title']])
            ->setTo($this->config()['admin_email'])
            ->setBody($render_mail, 'text/html');

        $success = false;

        if ((new Mailer())->mailer()->send($message)) {
            $success = true;
        }

        $this->render([
            'paste_id' => $request['id'],
            'success' => $success,
        ]);

        return $this->{'AbuseFormResults'};
    }
}
