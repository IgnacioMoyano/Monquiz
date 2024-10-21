<?php

class EmailSender{

    public  function send($to, $subject, $body,$userId, $token){
        $carpetaEmail = 'D:/XAMPP/htdocs/Monquiz/app/email/';



        $nombreArchivo = $carpetaEmail . md5($to) . '.txt';

        $content = "To: $to\n";
        $content .= "Subject: $subject\n";
        $content .= "Body:\n$body\n";
        $content .= "Validation URL: " . $this->generateValidationUrl($userId, $token) . "\n";


     file_put_contents($nombreArchivo, $content);

    }

    private function generateValidationUrl($userId, $token) {

        return "http://localhost/Monquiz/app/usuario/validar?id=$userId&token=$token";
    }

}