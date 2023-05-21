<?php

use PHPMailer\PHPMailer\PHPMailer;
use SendGrid\Mail\Mail;
use Mailgun\Mailgun;
use Mailgun\HttpClient\HttpClientConfigurator;
use Mailgun\Hydrator\NoopHydrator;


require_once 'connect.php';


class Mailer
{
	private $mailer;

    public function __construct(string $smtp = 'phpmailer', string $apiKey = '')
    {
        switch ($smtp) {
            case 'sendgrid':
                $this->mailer = new Mail();
                break;
            case 'mailgun':
              $configurator = new HttpClientConfigurator();
                $configurator->setEndpoint('http://bin.mailgun.net/aecf68de');
                $configurator->setApiKey($apiKey);
                $configurator->setDebug(true);
                $mg = new Mailgun($configurator, new NoopHydrator());
                $this->mailer = $mg;
                break;
            case 'phpmailer':
            default:
                $this->mailer = new PHPMailer(true);
                break;
        }
    }

    public function setSMTPAuth(string $username, string $password): void
    {
        if ($this->mailer instanceof PHPMailer) {
            $this->mailer->isSMTP();
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = $username;
            $this->mailer->Password = $password;
        }
    }

    public function setHTML(bool $isHTML): void
    {
        $this->mailer->isHTML($isHTML);
    }

    public function setAltBody(string $altBody): void
    {
        $this->mailer->AltBody = $altBody;
    }

    public function addAttachment(string $filePath): void
    {
        $this->mailer->addAttachment($filePath);
    }

    public function validate(): bool
    {
        if ($this->mailer instanceof PHPMailer) {
            return $this->mailer->validateAddress($this->mailer->From) &&
                $this->mailer->validateAddress($this->mailer->addAddress);
        }

        // For other mail libraries, implement validation logic here
        return false;
    }

    public function addRecipients(array $recipients): void
    {
        foreach ($recipients as $email => $name) {
            $this->mailer->addAddress($email, $name);
        }
    }

    public function embedImage(string $imagePath, string $cid): void
    {
        if ($this->mailer instanceof PHPMailer) {
            $this->mailer->addEmbeddedImage($imagePath, $cid);
        }
    }

    public function send(): bool
    {
        try {
            if ($this->mailer instanceof PHPMailer) {
                return $this->mailer->send();
            }

            // For other mail libraries, implement sending logic here
            return false;
        } catch (\Exception $e) {
            // Handle the exception here, e.g., log or display error messages
            return false;
        }
    }

    public function getErrors(): array
    {
        if ($this->mailer instanceof PHPMailer) {
            return $this->mailer->ErrorInfo;
        }

        // For other mail libraries, implement error handling here
        return [];
    }
	
	   public function addContent(string $type, string $content): void
    {
        if ($this->mailer instanceof Mail) {
            $this->mailer->addContent($type, $content);
        } elseif ($this->mailer instanceof PHPMailer) {
            if ($type === 'text/plain') {
                $this->mailer->Body = '';
                $this->mailer->AltBody = $content;
            } elseif ($type === 'text/html') {
                $this->mailer->Body = $content;
                $this->mailer->AltBody = '';
            }
        }
    }

}


// Example usage
$mailer = new Mailer('mailgun','690c89be1402f5953b3493e029aebe6d-db4df449-0fe5a4a3');

$mailer->setSMTPAuth('postmaster@sandbox3db2ffc9ece04d91960f0d6e453a1dc2.mailgun.org', 'a48b9f17da9ffc23b03b3461b5df8093-db4df449-8a854a27');
//$mailer->setHTML(true);

$mailer->addContent("text/plain", "and easy to do anywhere, even with PHP");

$mailer->setAltBody('This is the plain text version of the email.');
//$mailer->addAttachment('/path/to/file.pdf');
$mailer->addRecipients(['mohdakramabbasi@gmail.com' => 'Akram', 'example2@mail.com' => 'Example 2']);
//$mailer->embedImage('/path/to/image.jpg', 'image_cid');

if (!$mailer->validate()) {
    // Handle validation errors
    $errors = $mailer->getErrors();
    foreach ($errors as $error) {
        echo "Validation Error: $error\n";
    }
} else {
    if ($mailer->send()) {
        echo "Email sent successfully!\n";
    } else {
        // Handle sending errors
        $errors = $mailer->getErrors();
        foreach ($errors as $error) {
            echo "Sending Error: $error\n";
        }
    }
}




