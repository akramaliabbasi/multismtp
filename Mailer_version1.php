<?php


require_once 'connect.php';


class Mailer {
    private $mailer;
    private $sendGrid;
    private $mailgun;
    private $apiKey;
    
    public function __construct(string $apiKey) {
        $this->apiKey = $apiKey;
        $this->mailer = new PHPMailer();
        $this->sendGrid = new \SendGrid($this->apiKey);
        $this->mailgun = Mailgun::create($this->apiKey);
    }
    
    public function setFrom(string $email, string $name) {
        $this->mailer->setFrom($email, $name);
    }
    
    public function addTo(string $email, string $name) {
        $this->mailer->addAddress($email, $name);
    }
    
    public function addReplyTo(string $email, string $name) {
        $this->mailer->addReplyTo($email, $name);
    }
    
    public function addCc(array $recipients) {
        foreach ($recipients as $email => $name) {
            $this->mailer->addCC($email, $name);
        }
    }
    
    public function addBcc(array $recipients) {
        foreach ($recipients as $email => $name) {
            $this->mailer->addBCC($email, $name);
        }
    }
    
    public function setHTML(string $htmlContent) {
        $this->mailer->isHTML(true);
        $this->mailer->Body = $htmlContent;
    }
    
    public function setText(string $textContent) {
        $this->mailer->isHTML(false);
        $this->mailer->Body = $textContent;
    }
    
    public function setAltBody(string $altBody) {
        $this->mailer->AltBody = $altBody;
    }
    
    public function addAttachment(string $filePath) {
        $this->mailer->addAttachment($filePath);
    }
    
    public function useSMTP(string $host, int $port, string $username, string $password) {
        $this->mailer->isSMTP();
        $this->mailer->Host = $host;
        $this->mailer->Port = $port;
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $username;
        $this->mailer->Password = $password;
    }
    
    public function useSendGrid() {
        $this->mailer = new \SendGrid\Mail\Mail();
    }
    
    public function useMailgun() {
        $this->mailer = Mailgun::create($this->apiKey);
    }
    
    public function send() { die("sendgrid");
        try {
            if ($this->mailer instanceof PHPMailer) { 
                $this->mailer->send();
            } elseif ($this->mailer instanceof Mail) { 
                $this->sendGrid->send($this->mailer);
            } elseif ($this->mailer instanceof \Mailgun\Mail\MessageBuilder) {
                $this->mailer->send();
            }
            return true;
        } catch (\Exception $e) { 
            return $e->getMessage();
        }
    }
}


$mailer = new Mailer('690c89be1402f5953b3493e029aebe6d-db4df449-0fe5a4a3');

$mailer->setFrom('No-reply@mailer.com', 'Sender');
$mailer->addTo('mohdakramabbasi@gmail.com', 'Recipient');
//$mailer->addCc(['cc1@example.com' => 'CC 1', 'cc2@example.com' => 'CC 2']);
$mailer->setHTML('<p>This is the HTML version of the email.</p>');
$mailer->setText('This is the plain text version of the email.');
//$mailer->addAttachment('/path/to/attachment.pdf');
$mailer->useSMTP('smtp.mailgun.org', 587, 'postmaster@sandbox3db2ffc9ece04d91960f0d6e453a1dc2.mailgun.org', 'a48b9f17da9ffc23b03b3461b5df8093-db4df449-8a854a27');

$result = $mailer->send();
if ($result === true) {
    echo 'Email sent successfully.';
} else {
    echo 'An error occurred: ' . $result;
}
