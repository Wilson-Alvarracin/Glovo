<?php
// Incluir el archivo de conexión PDO
require_once 'conexion.php';

try {
    // Consulta SQL para obtener todos los restaurantes
    $sql = "SELECT id_restaurante, rest_nom FROM tbl_restaurante";
    $stmt = $conn->query($sql);
    $restaurantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Devolver la lista de restaurantes en formato JSON
    header('Content-Type: application/json');
    echo json_encode($restaurantes);
} catch (PDOException $e) {
    // En caso de error, devolver un mensaje de error
    http_response_code(500);
    echo json_encode(array('message' => 'Error al obtener la lista de restaurantes.'));
}
?>
