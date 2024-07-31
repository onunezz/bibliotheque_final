<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/PHPMailer/Exception.php';
require 'vendor/PHPMailer/PHPMailer.php';
require 'vendor/PHPMailer/SMTP.php';

class MailerController
{
    static public function sendNewUser($password, $email, $name, $last_name)
    {
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'alegusnunez@gmail.com';
        $mail->Password = 'thidqzsmpiarqjrx';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('alegusnunez@gmail.com', 'bibliotheque');
        $mail->addAddress($email, 'Usuario');
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = "¡Tu cuenta ha sido activada!";

        $htmlFile = 'views/html/activateAccount.html';


        $htmlContent = file_get_contents($htmlFile);
        $htmlContent = str_replace('{{name}}', $name, $htmlContent);
        $htmlContent = str_replace('{{last_name}}', $last_name, $htmlContent);
        $htmlContent = str_replace('{{email}}', $email, $htmlContent);
        $htmlContent = str_replace('{{password}}', $password, $htmlContent);
        $mail->Body = $htmlContent;
        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    }

    static public function generateNewPasswordviaEmail($email, $password)
    {

        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'alegusnunez@gmail.com';
        $mail->Password = 'thidqzsmpiarqjrx';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('alegusnunez@gmail.com', 'bibliotheque');
        $mail->addAddress($email, 'Usuario');
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = "¡Nueva clave generada!";

        $htmlFile = '../views/html/emailGeneratePassword.html';
        $htmlContent = file_get_contents($htmlFile);
        $htmlContent = str_replace('{{password}}', $password, $htmlContent);
        $mail->Body = $htmlContent;
        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    }
}
