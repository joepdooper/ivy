<?php
// PHPMailer class
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail {

  public function __construct() {
    $this->Address = null;
    $this->Name    = null;
    $this->Subject = null;
    $this->Body    = null;
    $this->AltBody = null;
  }

  function send() {

    $mail = new PHPMailer(true);

    try {
      //Server settings
      $mail->SMTPDebug = false;                                   //Enable verbose debug output SMTP::DEBUG_SERVER
      $mail->isSMTP();                                            //Send using SMTP
      $mail->Host       = MAIL_HOST;                              //Set the SMTP server to send through
      $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
      $mail->Username   = MAIL_USERNAME;                          //SMTP username
      $mail->Password   = MAIL_PASSWORD;                          //SMTP password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //`PHPMailer::ENCRYPTION_STARTTLS` Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
      $mail->Port       = MAIL_PORT;

      //Recipients
      $mail->setFrom(MAIL_SENDER_ADDRESS, MAIL_SENDER_NAME);
      $mail->addAddress($this->Address, $this->Name);             //Add a recipient
      $mail->addReplyTo(MAIL_SENDER_ADDRESS, MAIL_SENDER_NAME);

      //Content
      $mail->isHTML(true);                                        //Set email format to HTML
      $mail->Subject = $this->Subject;
      $mail->Body    = $this->Body;
      $mail->AltBody = $this->AltBody;

      $mail->send();

      return 'Message has been sent';
    } catch (Exception $e) {
      return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

  }

}
?>
