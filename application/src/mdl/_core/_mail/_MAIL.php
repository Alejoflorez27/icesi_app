<?php

use PHPMailer\PHPMailer\PHPMailer;

require  dirname(__FILE__, 5) . '/vendor/PHPMailer/src/Exception.php';
require  dirname(__FILE__, 5) . '/vendor/PHPMailer/src/PHPMailer.php';
require  dirname(__FILE__, 5) . '/vendor/PHPMailer/src/SMTP.php';

class MAIL extends PHPMailer
{

    public function __construct($to = "", $subject = "", $body = "")
    {
        parent::__construct(true);

        $this->setLanguage('es');
        $this->CharSet = 'UTF-8';

        //$this->SMTPDebug = 2; // Enable verbose debug output
        $this->isSMTP(); // Set mailer to use SMTP

        try {
            $this->Host = constant('PROVIDER_MAIL_HOST'); //'smtp.gmail.com'; // Specify main and backup SMTP servers
            $this->SMTPAuth = constant('PROVIDER_MAIL_SMTP_AUTH'); //true; // Enable SMTP authentication
            $this->Username = constant('PROVIDER_MAIL_USER'); // SMTP username
            $this->Password = constant('PROVIDER_MAIL_PASSWORD'); //SMTP password
            $this->SMTPSecure = constant('PROVIDER_MAIL_SMTP_SECURE'); //'tls'; // Enable TLS encryption, `ssl` also accepted
            $this->Port = constant('PROVIDER_MAIL_PORT'); // 587; // TCP port to connect to
        } catch (Exception $e) {
            null;
        }

        $this->isHTML(true);

        //Recipients
        $this->setFrom(constant('PROVIDER_MAIL_USER'), constant('PROVIDER_MAIL_FROM'));

        if ($to != "" && $to != null) {
            try {
                $this->addAddress($to); // Add a recipient
            } catch (Exception $e) {
                null;
            }
        }

        //$this->addReplyTo('info@example.com', 'Information');
        //$this->addCC('cc@example.com');
        //$this->addBCC('bcc@example.com');

        //Attachments
        //$this->addAttachment('/var/tmp/file.tar.gz'); // Add attachments
        //$this->addAttachment('/tmp/image.jpg', 'new.jpg'); // Optional name

        //Content
        $this->isHTML(true); // Set email format to HTML
        if ($subject != "" && $subject != null) {
            try {
                $this->Subject = $subject;
            } catch (Exception $e) {
                null;
            }
        }

        if ($body != "" && $body != null) {
            try {
                $this->Body = $body;
            } catch (Exception $e) {
                null;
            }
        }
        //$this->AltBody = 'This is the body in plain text for non-HTML mail clients';

    }
}
