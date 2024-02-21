<?php
// Obtener los datos enviados por POST
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$rol = $_POST['rol'];

// Validar el email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response = array('success' => false, 'message' => 'El formato del correo electrónico no es válido.');
    echo json_encode($response);
    exit();
}

// Verificar si se proporcionó una nueva contraseña
if (!empty($_POST['password'])) {
    $password = $_POST['password'];
    // Validar la longitud de la contraseña
    if (strlen($password) < 5) {
        $response = array('success' => false, 'message' => 'La contraseña debe tener al menos 5 caracteres.');
        echo json_encode($response);
        exit();
    }
    // Cifrar la contraseña
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    // Incluir el hash de la contraseña en la actualización
    $sql = "UPDATE tbl_usr SET usr_nom = :nombre, usr_ape = :apellido, usr_email = :email, usr_pwd = :password, usr_rol = :rol WHERE id_usr = :id";
} else {
    // Si no se proporcionó una nueva contraseña, excluirla de la actualización
    $sql = "UPDATE tbl_usr SET usr_nom = :nombre, usr_ape = :apellido, usr_email = :email, usr_rol = :rol WHERE id_usr = :id";
}

// Incluir el archivo de conexión PDO
require_once 'conexion.php';

try {
    // Realizar la actualización del usuario
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apellido', $apellido);
    $stmt->bindParam(':email', $email);
    // Si se proporcionó una nueva contraseña, incluirla en la actualización
    if (!empty($_POST['password'])) {
        $stmt->bindParam(':password', $hashedPassword);
    }
    $stmt->bindParam(':rol', $rol);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Verificar si se realizó la actualización correctamente
    $rowCount = $stmt->rowCount();
    if ($rowCount > 0) {
        // Actualización exitosa
        $response = array('success' => true, 'message' => 'Usuario actualizado correctamente.');
    } else {
        // No se pudo actualizar
        $response = array('success' => false, 'message' => 'No se pudo actualizar el usuario.');
    }
} catch (PDOException $e) {
    // Error en la conexión o la consulta
    $response = array('success' => false, 'message' => 'Error: ' . $e->getMessage());
}

// Devolver la respuesta en formato JSON
echo json_encode($response);
?>
