<?php
// Verificar si se ha enviado un ID por POST
if (isset($_POST['id'])) {
    // Incluir el archivo de conexión PDO
    require_once 'conexion.php';

    // Obtener el ID del restaurante
    $id = $_POST['id'];

    try {
        // Preparar la consulta SQL para obtener los detalles del restaurante por su ID
        $sql = "SELECT * FROM tbl_restaurante WHERE id_restaurante = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Obtener los detalles del restaurante
        $restaurante = $stmt->fetch(PDO::FETCH_ASSOC);

        // Devolver los detalles del restaurante como JSON
        echo json_encode($restaurante);
    } catch (PDOException $e) {
        // Manejar errores
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    // Devolver un mensaje de error si no se proporciona un ID
    echo json_encode(['error' => 'No se ha proporcionado un ID de restaurante']);
}
?>
