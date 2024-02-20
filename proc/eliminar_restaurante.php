<?php
// Verificar si se ha enviado un ID por POST
if (isset($_POST['id'])) {
    // Incluir el archivo de conexión PDO
    require_once 'conexion.php';

    // Obtener el ID del restaurante
    $id = $_POST['id'];

    try {
        // Eliminar los registros de tbl_restu_cocina relacionados con el restaurante
        $sqlDeleteRestuCocina = "DELETE FROM tbl_restu_cocina WHERE id_restaurante = :id";
        $stmtDeleteRestuCocina = $conn->prepare($sqlDeleteRestuCocina);
        $stmtDeleteRestuCocina->bindParam(':id', $id);
        $stmtDeleteRestuCocina->execute();

        // Eliminar los platos asociados al restaurante
        $sqlDeletePlatos = "DELETE FROM tbl_platos WHERE id_restaurante = :id";
        $stmtDeletePlatos = $conn->prepare($sqlDeletePlatos);
        $stmtDeletePlatos->bindParam(':id', $id);
        $stmtDeletePlatos->execute();

        // Eliminar el restaurante
        $sqlDeleteRestaurante = "DELETE FROM tbl_restaurante WHERE id_restaurante = :id";
        $stmtDeleteRestaurante = $conn->prepare($sqlDeleteRestaurante);
        $stmtDeleteRestaurante->bindParam(':id', $id);
        $stmtDeleteRestaurante->execute();

        // Devolver un mensaje de éxito
        echo json_encode(['success' => true, 'message' => 'El restaurante y sus platos han sido eliminados correctamente']);
    } catch (PDOException $e) {
        // Manejar errores
        echo json_encode(['success' => false, 'message' => 'Error al eliminar el restaurante y sus platos: ' . $e->getMessage()]);
    }
} else {
    // Devolver un mensaje de error si no se proporciona un ID
    echo json_encode(['success' => false, 'message' => 'No se ha proporcionado un ID de restaurante']);
}
?>
