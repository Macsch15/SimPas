<?php
namespace Application\Mailer;

use Application\Application;
use Application\Configuration\Configuration;
use Swift_SmtpTransport;
use Swift_Mailer;
use Swift_Message;

class Mailer
{
    use Configuration;

    /**
    * Construct
    * 
    * @return void
    */
    public function __construct()
    {
        // Include needed libraries
        require_once Application::makePath('library:Swiftmailer:lib:swift_required.php');
    }

    /**
    * Mailer width transport
    * 
    * @return Swift_Mailer object
    */
    public function mailer()
    {
        $transport = Swift_SmtpTransport::newInstance($this->config('SmtpMailer')->host, $this->config('SmtpMailer')->port, 
            $this->config('SmtpMailer')->protocol);

        if($this->config('SmtpMailer')->username != null) {
            $transport->setUsername($this->config('SmtpMailer')->username);
        }

        if($this->config('SmtpMailer')->password != null) {
            $transport->setPassword($this->config('SmtpMailer')->password);
        }

        return Swift_Mailer::newInstance($transport);
    }

    /**
    * Message accessor
    * 
    * @param string $subject 
    * @return Swift_Message object
    */
    public function message($subject = null)
    {
        return Swift_Message::newInstance($subject);
    }
}
