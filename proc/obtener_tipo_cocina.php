<?php
// Incluir el archivo de conexión PDO
require_once 'conexion.php';

try {
    // Consulta SQL para obtener todos los tipos de cocina
    $sql = "SELECT id_cocina, cocina_nom FROM tbl_cocinas";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Obtener los resultados como un array asociativo
    $tiposCocina = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Devolver los tipos de cocina en formato JSON
    echo json_encode(['success' => true, 'data' => $tiposCocina]);
} catch (PDOException $e) {
    // Manejar errores
    echo json_encode(['success' => false, 'message' => 'Error al obtener los tipos de cocina: ' . $e->getMessage()]);
}
?>
