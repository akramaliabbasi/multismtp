# multismtp psudo code example
multi smtp i.e PHPmailer SendGrid Mailgun





-----------------------------
PHP 8 Mailer Class
-----------------------------

You’re assigned to create a PHP 8 Mailer Class that should be easy to use within any existing project and send mails by creating a new instance of that class. The class should be provided with public available methods to add information like, and its’ up to you to name them:

From, To, ReplyTo, Cc, Bcc, Attachments, HTML and Text versions and Validation.
It must be possible to add multiple To, Cc, Bcc through arrays with both e-mail and names.
The preferred usage would be: [ example@mail.com => ‘Example Name’ ]

For this assignment we shall provide 3 libraries which must be included in the class.
These libraries will be responsible for sending the e-mail message out, take in consideration that another developer in the future must be able to simply add new libraries to the class that you’re creating right now. When using instances of the Mailer class it should be easily possible to use another API – it’s up to you to decide what is the easiest way of doing so.

If you have any more suggestions for functions which may be used in a Mailer Class, feel free to add them to this assignment. There are a few things you need to take in consideration while developing this class. It all must be atleast PHP 8 Syntax and should be written in the most efficient way that you know. 

Syntax: 			PHP >= 8.0 Syntax
Libraries:

PHPmailer:			https://github.com/PHPMailer/PHPMailer
SendGrid:			https://github.com/sendgrid/sendgrid-php
Mailgun:			https://github.com/mailgun/mailgun-php

Requirements:

1.	Option to use SMTP authentication.
2.	Option to set if message uses HTML or is plain text.
3.	Option to always add ‘AltBody’ message in plain text.
4.	Option to send attachments of allowed extensions.
5.	Option to check validation of the created Mailer class.
6.	Option to choose what API to use, and easily switch to another.
7.	Option to embed images (instead of adding as attachment) for all API’s.
8.	Option to return error/warning messages of what went wrong (or will go wrong).
9.	Option to add multiple recipients through arrays: To, Cc, Bcc.
10.	Make sure everything is named logically and try to keep it lightweight.
11.	Make sure the class handles localization, for example with error messages.
You can stick to languages English and Dutch for now.

Credential to test:

1.	[Mailgun Credentials]
2.	[SendGrid Credentials]

