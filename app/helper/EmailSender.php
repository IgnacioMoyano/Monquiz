<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Usa rutas relativas o absolutas correctas
require __DIR__ . '/../vendor/PHPMailer-master/src/Exception.php';
require __DIR__ . '/../vendor/PHPMailer-master/src/PHPMailer.php';
require __DIR__ . '/../vendor/PHPMailer-master/src/SMTP.php';

class EmailSender{



    public  function send($to, $subject, $body,$userId, $token)
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   //Enable SMTP authentication
            $mail->Username = 'mmonquiz@gmail.com';                     //SMTP username
            $mail->Password = 'pyjbgxocvvhliypk';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('mmonquiz@gmail.com', 'Monquiz');
            $mail->addAddress($to, 'Client');     //Add a recipient


            $url = $this->generateValidationUrl($userId, $token);
            $content = $body;
            $content .= "<a href=$url> Click aqui! </a>";
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = $content;
            $mail->AltBody = $content;

            $mail->send();

        } catch (Exception $e) {
            
        }
    }


   private function generateValidationUrl($userId, $token) {

      return "http://localhost/Monquiz/app/usuario/validar?id=$userId&token=$token";
   }



}