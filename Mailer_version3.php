<?php

<?php

use PHPMailer\PHPMailer\PHPMailer;
use SendGrid\Mail\Mail as SendGridMail;
use Mailgun\Mailgun;

class Mailer
{
    private $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer();
    }

    public function setSMTPAuth($enabled)
    {
        $this->mailer->SMTPAuth = $enabled;
    }

    public function setHTML($enabled)
    {
        $this->mailer->isHTML($enabled);
    }

    public function setAltBody($altBody)
    {
        $this->mailer->AltBody = $altBody;
    }

    public function addAttachment($path)
    {
        $this->mailer->addAttachment($path);
    }

    public function validate()
    {
        return $this->mailer->validateAddress($this->mailer->From);
    }

    public function setFrom($email, $name)
    {
        $this->mailer->setFrom($email, $name);
    }

    public function addTo($email, $name)
    {
        $this->mailer->addAddress($email, $name);
    }

    public function addCc($email, $name)
    {
        $this->mailer->addCC($email, $name);
    }

    public function addBcc($email, $name)
    {
        $this->mailer->addBCC($email, $name);
    }

    public function setSubject($subject)
    {
        $this->mailer->Subject = $subject;
    }

    public function setBody($body)
    {
        $this->mailer->Body = $body;
    }

    public function send()
    {
        try {
            // Replace with your preferred API choice
            // For example, here we are using PHPMailer with SMTP
            $this->mailer->isSMTP();
            $this->mailer->Host = 'smtp.example.com';
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = 'your_username';
            $this->mailer->Password = 'your_password';
            $this->mailer->Port = 587;

            return $this->mailer->send();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function embedImage($path, $cid)
    {
        $this->mailer->addEmbeddedImage($path, $cid);
    }
}

// Usage example:

$mailer = new Mailer();
$mailer->setSMTPAuth(true);
$mailer->setHTML(true);
$mailer->setAltBody('This is the plain text version');
$mailer->addAttachment('/path/to/file.pdf');
$mailer->setFrom('from@example.com', 'Sender');
$mailer->addTo('recipient1@example.com', 'Recipient 1');
$mailer->addCc('cc@example.com', 'CC Recipient');
$mailer->addBcc('bcc@example.com', 'BCC Recipient');
$mailer->setSubject('Test Email');
$mailer->setBody('<h1>Hello!</h1><p>This is the HTML body of the email.</p>');
$mailer->embedImage('/path/to/image.jpg', 'image_cid');

$result = $mailer->send();
if ($result === true) {
    echo 'Email sent successfully.';
} else {
    echo 'Error sending email: ' . $result;
}
