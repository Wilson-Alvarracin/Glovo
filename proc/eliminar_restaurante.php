<?php
// Verificar si se ha enviado un ID por POST
if (isset($_POST['id'])) {
    // Incluir el archivo de conexión PDO
    require_once 'conexion.php';

    // Obtener el ID del restaurante
    $id = $_POST['id'];

    try {
        // Preparar la consulta SQL para eliminar el restaurante por su ID
        $sql = "DELETE FROM tbl_restaurante WHERE id_restaurante = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Devolver un mensaje de éxito
        echo json_encode(['success' => true, 'message' => 'El restaurante ha sido eliminado correctamente']);
    } catch (PDOException $e) {
        // Manejar errores
        echo json_encode(['success' => false, 'message' => 'Error al eliminar el restaurante: ' . $e->getMessage()]);
    }
} else {
    // Devolver un mensaje de error si no se proporciona un ID
    echo json_encode(['success' => false, 'message' => 'No se ha proporcionado un ID de restaurante']);
}
?>
