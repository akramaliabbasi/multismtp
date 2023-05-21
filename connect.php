<?php

//mailgun load

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use SendGrid\Mail\Mail;
use Mailgun\Mailgun;



require_once __DIR__ .'/vendor/autoload.php';

//send grid
require_once __DIR__ .'/vendor/sendgrid/sendgrid-php.php';

require_once __DIR__ . '/vendor/PHPMailer/src/PHPMailer.php';

//phpmailer
require_once __DIR__ . '/vendor/phpmailer/src/Exception.php';
require_once __DIR__ . '/vendor/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/vendor/phpmailer/src/SMTP.php';

