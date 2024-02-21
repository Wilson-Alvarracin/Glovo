<?php
// Incluir el archivo de conexión PDO
require_once 'conexion.php';

// Verificar si se recibió el correo electrónico
if (isset($_POST['email'])) {
    // Obtener el correo electrónico enviado desde la solicitud AJAX
    $email = $_POST['email'];

    try {
        // Consultar la base de datos para verificar si el correo ya está en uso
        $sql = "SELECT COUNT(*) AS count FROM tbl_usuarios WHERE correo = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si la consulta devuelve un resultado mayor que cero, significa que el correo está en uso
        if ($result['count'] > 0) {
            // Devolver una respuesta indicando que el correo está en uso
            echo json_encode(array('exists' => true));
        } else {
            // Devolver una respuesta indicando que el correo no está en uso
            echo json_encode(array('exists' => false));
        }
    } catch (PDOException $e) {
        // En caso de error, devolver un mensaje de error
        http_response_code(500);
        echo json_encode(array('message' => 'Error al verificar el correo electrónico: ' . $e->getMessage()));
    }
} else {
    // Si no se recibió el correo electrónico, devolver un mensaje de error
    http_response_code(400);
    echo json_encode(array('message' => 'Correo electrónico no proporcionado.'));
}
?>
