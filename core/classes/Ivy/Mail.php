<?php

namespace Ivy;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    public string $Address;
    public string $Name;
    public string $Subject;
    public string $Body;
    public string $AltBody;

    function send(): string
    {

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = false;                                   //Enable verbose debug output SMTP::DEBUG_SERVER
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host = $_ENV['MAIL_HOST'];                     //Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   //Enable SMTP authentication
            $mail->Username = $_ENV['MAIL_USERNAME'];                 //SMTP username
            $mail->Password = $_ENV['MAIL_PASSWORD'];                 //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //`PHPMailer::ENCRYPTION_STARTTLS` Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port = $_ENV['MAIL_PORT'];

            //Recipients
            $mail->setFrom($_ENV['MAIL_SENDER_ADDRESS'], $_ENV['MAIL_SENDER_NAME']);
            $mail->addAddress($this->Address, $this->Name);             //Add a recipient
            $mail->addReplyTo($_ENV['MAIL_SENDER_ADDRESS'], $_ENV['MAIL_SENDER_NAME']);

            //Content
            $mail->isHTML();                                       //Set email format to HTML
            $mail->Subject = $this->Subject;
            $mail->Body = $this->Body;
            $mail->AltBody = $this->AltBody;

            $mail->send();

            return 'Message has been sent';
        } catch (Exception) {
            return "Message could not be sent. Mailer Error: $mail->ErrorInfo";
        }

    }

}
