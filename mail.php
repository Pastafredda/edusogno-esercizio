<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/phpmailer/phpmailer/src/Exception.php';
require './vendor/phpmailer/phpmailer/src/PHPMailer.php';
require './vendor/phpmailer/phpmailer/src/SMTP.php';

function sendMail($to, $subject, $body) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';  
        $mail->SMTPAuth   = true;
        $mail->Username   = 'sicuramenteunemail@gmail.com';  
        $mail->Password   = 'brhz qjin drtf ngaj';        
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('tuomail@gmail.com', 'Mailer');
        $mail->addAddress($to);
        $mail->isHTML(true);  
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        echo 'Il messaggio è stato inviato';
    } catch (Exception $e) {
        echo "Il messaggio non può essere inviato. Errore Mailer: {$mail->ErrorInfo}";
    }
}

?>
