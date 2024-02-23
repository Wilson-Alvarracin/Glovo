<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/autoload.php'; // Asegúrate de que la ruta sea correcta según tu configuración

// Verifica si se recibió el destinatario del correo electrónico
if(isset($_POST['destinatario'])) {
    // Obtén el destinatario del correo electrónico desde la solicitud AJAX
    $destinatario = $_POST['destinatario'];

    try {
        // Crea una nueva instancia de PHPMailer
        $mail = new PHPMailer(true);

        // Configura el servidor SMTP de Gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'glovodaw@gmail.com'; // Tu dirección de correo electrónico de Gmail
        $mail->Password = 'ivanmoreno18'; // Tu contraseña de Gmail
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587; // Puerto SMTP

        // Configura el remitente y el destinatario
        $mail->setFrom('glovodaw@gmail.com', 'Tu Nombre');
        $mail->addAddress($destinatario);

        // Contenido del correo electrónico
        $mail->isHTML(true);
        $mail->Subject = 'Asunto del Correo';
        $mail->Body    = 'Contenido del Correo';

        // Envía el correo electrónico
        $mail->send();

        echo json_encode(array('success' => true));
    } catch (Exception $e) {
        // Si ocurre algún error, devuelve un mensaje de error
        echo json_encode(array('success' => false, 'message' => 'Error al enviar el correo electrónico: ' . $mail->ErrorInfo));
    }
} else {
    // Si no se proporcionó el destinatario del correo electrónico, devuelve un mensaje de error
    echo json_encode(array('success' => false, 'message' => 'Destinatario del correo electrónico no recibido'));
}
?>
