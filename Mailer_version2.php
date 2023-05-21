<?php

require_once 'connect.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use SendGrid\Mail\Mail;
use Mailgun\Mailgun;

class Mailer
{
    private $mailer;
    private $domain;

    public function __construct()
    {
        $this->mailer = new PHPMailer();
    }

    public function setSMTPAuth($username, $password)
    {
        $this->mailer->isSMTP();
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $username;
        $this->mailer->Password = $password;
    }

    public function setHTML($isHTML)
    {
        $this->mailer->isHTML($isHTML);
    }

    public function setAltBody($altBody)
    {
        $this->mailer->AltBody = $altBody;
    }

    public function addAttachment($filePath)
    {
        $this->mailer->addAttachment($filePath);
    }

    public function validate()
    {
        return $this->mailer->validateAddress($this->mailer->Username) &&
            $this->mailer->validateAddress($this->mailer->addAddress);
    }

    public function useSMTP()
    {
        $this->mailer = new PHPMailer();
    }

    public function useSendGrid($apiKey)
    {
        $this->mailer = new Mail();
        $this->mailer->setApiKey($apiKey);
    }

    public function useMailgun($apiKey, $domain)
    {
        $mgClient = Mailgun::create($apiKey);
        $this->mailer = $mgClient->messages();
        $this->domain = $domain;
    }

    public function addRecipients($recipients)
    {
        foreach ($recipients as $email => $name) {
            $this->mailer->addAddress($email, $name);
        }
    }

    public function send()
    {
        try {
            if ($this->mailer instanceof Mailgun) {
                $message = $this->mailer->send($this->domain, [
                    'from' => $this->mailer->getFrom(),
                    'to' => $this->mailer->getTo(),
                    'subject' => $this->mailer->getSubject(),
                    'html' => $this->mailer->getHtmlBody(),
                    'text' => $this->mailer->getTextBody(),
                ]);
                return $message->getId();
            } else {
                return $this->mailer->send();
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}

$mailer = new Mailer();
$mailer->setSMTPAuth('postmaster@sandbox3db2ffc9ece04d91960f0d6e453a1dc2.mailgun.org', 'a48b9f17da9ffc23b03b3461b5df8093-db4df449-8a854a27');
$mailer->setHTML(true);
$mailer->setAltBody('This is the plain text version of the email');
$mailer->addRecipients(['mohdakramabbasi@gmail.com' => 'Example Name']);

$mailer->useMailgun('690c89be1402f5953b3493e029aebe6d-db4df449-0fe5a4a3', 'localhost.com');

$result = $mailer->send();

if (!empty($result)) {
    echo 'Email sent successfully. Message ID: ' . $result;
} else {
    echo 'Email sending failed.';
}
