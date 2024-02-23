<?php
require_once 'conexion.php';

// Verificar si se reciben los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $rol = $_POST['rol'];

    // Verificar si el correo ya está en uso
    $stmt = $conn->prepare('SELECT COUNT(*) AS count FROM tbl_usr WHERE usr_email = :email');
    $stmt->execute(array(':email' => $email));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $emailExists = $row['count'] > 0;

    if ($emailExists) {
        // Enviar una respuesta de error si el correo ya está en uso
        echo json_encode(array('success' => false, 'message' => 'Correo no disponible'));
    } else {
        try {
            // Preparar la consulta para insertar un nuevo usuario
            $stmt = $conn->prepare('INSERT INTO tbl_usr (usr_nom, usr_ape, usr_email, usr_pwd, usr_rol) VALUES (:nombre, :apellido, :email, :password, :rol)');
            // Ejecutar la consulta con los datos recibidos
            $stmt->execute(array(
                ':nombre' => $nombre,
                ':apellido' => $apellido,
                ':email' => $email,
                ':password' => $password,
                ':rol' => $rol
            ));

            // Enviar una respuesta al frontend
            echo json_encode(array('success' => true, 'message' => 'Usuario creado exitosamente'));

        } catch(PDOException $e) {
            // Enviar una respuesta de error al frontend si ocurre algún problema
            echo json_encode(array('success' => false, 'message' => 'Error al crear el usuario: ' . $e->getMessage()));
        }
    }
} else {
    // Enviar una respuesta de error si la solicitud no es de tipo POST
    echo json_encode(array('success' => false, 'message' => 'Método de solicitud no válido'));
}
?>
