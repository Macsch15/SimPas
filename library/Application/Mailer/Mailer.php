<?php

namespace Application\Mailer;

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
     * Mailer width transport.
     *
     * @throws MailerException
     *
     * @return Swift_Mailer object
     */
    public function mailer()
    {
        switch ($this->config('mailer')['transport']) {
            case 'smtp':
                if (function_exists('proc_open') === false) {
                    throw new MailerException('proc_* functions are not available on your PHP installation. This is required for SMTP transport.');
                }

                $transport = (new Swift_SmtpTransport($this->config('mailer')['host'], $this->config('mailer')['port']))
                    ->setUsername($this->config('mailer')['username'])
                    ->setPassword($this->config('mailer')['password']);
                break;
            case 'mail':
            default:
                $transport = new Swift_MailTransport();
                break;
            case 'sendmail':
                if (function_exists('proc_open') === false) {
                    throw new MailerException('proc_* functions are not available on your PHP installation. This is required for Sendmail transport.');
                }

                $transport = new Swift_SendmailTransport($this->config()['sendmail_command']);
                break;
        }

        return new Swift_Mailer($transport);
    }

    /**
     * Message accessor.
     *
     * @param string $subject
     *
     * @return Swift_Message object
     */
    public function message($subject = null)
    {
        return new Swift_Message($subject);
    }
}
