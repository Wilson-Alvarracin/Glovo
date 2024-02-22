<?php
// Incluir el archivo de conexión PDO
require_once 'conexion.php';

// Consulta SQL para obtener todos los restaurantes
$sql = "SELECT id_restaurante, rest_nom FROM tbl_restaurante";

// Preparar la consulta SQL
$stmt = $conn->query($sql);

// Inicializar un array para almacenar los restaurantes
$restaurantes = array();

// Agregar cada restaurante al array
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $restaurantes[] = $row;
}

// Devolver los restaurantes en formato JSON
echo json_encode($restaurantes);
?>
