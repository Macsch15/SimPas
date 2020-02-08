<?php
namespace Application\Mailer;

use Application\Application;
use Application\Configuration\Configuration;
use Application\Exception\MailerException;
use Swift_Mailer;
use Swift_MailTransport;
use Swift_Message;
use Swift_SendmailTransport;
use Swift_SmtpTransport;

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
     * @throws MailerException
     */
    public function mailer()
    {
        switch($this->config('mailer')['transport']) {
            case 'smtp':
                if (function_exists('proc_open') === false) {
                    throw new MailerException('proc_* functions are not available on your PHP installation. This is required for SMTP transport.');
                }

                $transport = Swift_SmtpTransport::newInstance($this->config('mailer')['host'], $this->config('mailer')['port'],
                    $this->config('mailer')['protocol'])
                ->setUsername($this->config('mailer')['username'])
                ->setPassword($this->config('mailer')['password']);
                break;
            case 'mail':
            default:
                $transport = Swift_MailTransport::newInstance();
                break;
            case 'sendmail':
                if (function_exists('proc_open') === false) {
                    throw new MailerException('proc_* functions are not available on your PHP installation. This is required for Sendmail transport.');
                }

                $transport = Swift_SendmailTransport::newInstance($this->config()['sendmail_command']);
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
