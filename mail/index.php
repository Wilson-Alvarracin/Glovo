<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com ';              //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'manolo.glovo.daw@gmail.com';
    $mail->Password   = 'mbjj isli ndto telr';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption  ssl
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('manolo.glovo.daw@gmail.com', 'Manolo');
    
    $mail->addAddress('hugo10040608@gmail.com', 'Hugo');     //Add a recipient
    $mail->addAddress('manolo.glovo.daw@gmail.com', 'Manolo');
    // $mail->addAddress('ellen@example.com');               //Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    // //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Cambio realizado';
    $mail->Body    = 'El admin ha hecho cambios en el restaurante!</b>';
    $mail->AltBody = 'El admin ha hecho cambios en el restaurante!';

    $mail->send();
    echo 'Enviado';
} catch (Exception $e) {
    echo "Error al mandar mail. Mailer Error: {$mail->ErrorInfo}";
}