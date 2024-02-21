<?php
// Conectar a la base de datos
require_once 'conexion.php';

// Consulta SQL para obtener todos los restaurantes
$sql = "SELECT id_restaurante, rest_nom FROM tbl_restaurante";

try {
    // Preparar la consulta
    $stmt = $conn->prepare($sql);
    // Ejecutar la consulta
    $stmt->execute();
    // Obtener los resultados
    $restaurantes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Devolver los resultados en formato JSON
    echo json_encode(array('success' => true, 'data' => $restaurantes));
} catch(PDOException $e) {
    // En caso de error, devolver un mensaje de error en formato JSON
    echo json_encode(array('success' => false, 'message' => 'Error al obtener los restaurantes: ' . $e->getMessage()));
}
?>
