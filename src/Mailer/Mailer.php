<?php

namespace SimPas\Mailer;

use SimPas\Configuration\Configuration;
use SimPas\Exception\MailerException;
use Swift_Mailer;
use Swift_MailTransport;
use Swift_Message;
use Swift_SendmailTransport;
use Swift_SmtpTransport;

class Mailer
{
    use Configuration;

    /**
     * @return Swift_Mailer
     * @throws MailerException
     */
    public function mailer(): Swift_Mailer
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
     * @param null $subject
     * @return Swift_Message
     */
    public function message($subject = null)
    {
        return new Swift_Message($subject);
    }
}
