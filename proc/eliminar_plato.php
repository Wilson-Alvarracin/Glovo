<?php
// Incluir el archivo de conexión PDO
require_once 'conexion.php';

// Verificar si se recibió el ID del plato a eliminar
if (isset($_POST['id_plato'])) {
    // Obtener el ID del plato desde la solicitud POST
    $id_plato = $_POST['id_plato'];

    // Consulta SQL para eliminar el plato
    $sql = "DELETE FROM tbl_platos WHERE id_plato = :id_plato";
    
    try {
        // Preparar la consulta para ejecución
        $stmt = $conn->prepare($sql);
        // Vincular el parámetro ID del plato
        $stmt->bindParam(':id_plato', $id_plato, PDO::PARAM_INT);
        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Si la eliminación fue exitosa, devolver una respuesta de éxito
            echo json_encode(['success' => true, 'message' => 'Plato eliminado correctamente']);
        } else {
            // Si ocurrió un error durante la eliminación, devolver un mensaje de error
            echo json_encode(['success' => false, 'message' => 'Error al eliminar el plato']);
        }
    } catch (PDOException $e) {
        // En caso de excepción, devolver un mensaje de error
        echo json_encode(['success' => false, 'message' => 'Error al procesar la solicitud: ' . $e->getMessage()]);
    }
} else {
    // Si no se recibió el ID del plato, devolver un mensaje de error
    echo json_encode(['success' => false, 'message' => 'No se proporcionó el ID del plato']);
}
?>
