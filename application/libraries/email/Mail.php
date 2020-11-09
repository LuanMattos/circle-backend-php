<?php
require_once 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail{
    public function __construct(){
    }
    public function send( $param = Array() ){
        $mail = new PHPMailer(true);
        try {
            //Server settings
//            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.mail.us-east-1.awsapps.com';      // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'account@atos.click';                   // SMTP username
            $mail->Password   = 'K2l9g3v1';                             // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom($param['from'], $param['name']);
            $mail->addAddress($param['to'], $param['name_to']);     // Add a recipient
//            $mail->addAddress('ellen@example.com');               // Name is optional
//            $mail->addReplyTo('info@example.com', 'Information');
//            $mail->addCC('cc@example.com');
//            $mail->addBCC('bcc@example.com');

            // Anexos
//            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);//email no formato html?
            $mail->Subject = $param['assunto'];//assunto
            $mail->Body    = $param['corpo_html'];//corpo do email, pode ser html
            $mail->AltBody = $param['corpo'];//corpo nao html

            $mail->send();
            return true;
        } catch (Exception $e) {
            return $mail->ErrorInfo;
        }

    }


}