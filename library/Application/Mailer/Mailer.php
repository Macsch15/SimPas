<?php
namespace Application\Mailer;

use Application\Application;
use Application\Configuration\Configuration;
use Application\Exception\MailerException;
use Swift_SmtpTransport;
use Swift_Mailer;
use Swift_Message;
use Swift_MailTransport;
use Swift_SendmailTransport;

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
    * @throws MailerException
    * @return Swift_Mailer object
    */
    public function mailer()
    {
        switch($this->config('Mailer')->transport) {
            case 'smtp':
                if(function_exists('proc_open') === false) {
                    throw new MailerException('proc_* functions are not available on your PHP installation. This is required for SMTP transport.');
                }

                $transport = Swift_SmtpTransport::newInstance($this->config('Mailer')->host, $this->config('Mailer')->port, 
                    $this->config('Mailer')->protocol)
                ->setUsername($this->config('Mailer')->username)
                ->setPassword($this->config('Mailer')->password);
                break;
            case 'mail':
            default:
                $transport = Swift_MailTransport::newInstance();
                break;
            case 'sendmail':
                if(function_exists('proc_open') === false) {
                    throw new MailerException('proc_* functions are not available on your PHP installation. This is required for Sendmail transport.');
                }

                $transport = Swift_SendmailTransport::newInstance($this->config()->sendmail_command);
                break;
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
