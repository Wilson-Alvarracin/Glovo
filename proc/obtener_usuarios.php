<?php
// Incluir el archivo de conexión PDO
require_once 'conexion.php';

// Consulta SQL para obtener los usuarios con todos los campos
$sql = "SELECT id_usr AS id, usr_nom AS nombre, usr_ape AS apellido, usr_email AS email, usr_pwd AS password, usr_rol AS rol FROM tbl_usr";
$stmt = $conn->prepare($sql);
$stmt->execute();

// Crear un array para almacenar los datos de los usuarios
$usuarios = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $usuarios[] = $row;
}

// Devolver los datos de los usuarios como JSON
echo json_encode($usuarios);
?>
