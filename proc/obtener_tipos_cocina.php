<?php
// Incluir el archivo de conexión PDO
require_once 'conexion.php';

// Array para almacenar los tipos de cocina
$tiposCocina = array();

// Consulta SQL para obtener todos los tipos de cocina
$sql = "SELECT id_cocina, cocina_nom FROM tbl_cocinas";

$stmt = $conn->prepare($sql);
$stmt->execute();

// Obtener los resultados y almacenarlos en el array $tiposCocina
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $tiposCocina[] = $row;
}

// Crear el array de respuesta
$response = array(
    'success' => true,
    'data' => $tiposCocina
);

// Devolver la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
