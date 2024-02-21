<?php
// Incluir el archivo de conexión PDO
require_once 'conexion.php';

// Verificar si se recibieron los datos esperados
if (isset($_POST['id_plato'], $_POST['nombre'], $_POST['precio'], $_POST['id_restaurante'])) {
    // Obtener los datos del formulario
    $id_plato = $_POST['id_plato'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $id_restaurante = $_POST['id_restaurante'];

    // Actualizar los datos del plato en la base de datos
    $sql = "UPDATE tbl_platos SET plato_descripcion = :nombre, plato_precio = :precio, id_restaurante = :id_restaurante WHERE id_plato = :id_plato";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':precio', $precio);
    $stmt->bindParam(':id_restaurante', $id_restaurante);
    $stmt->bindParam(':id_plato', $id_plato);
    if ($stmt->execute()) {
        // Si la actualización fue exitosa, devolver una respuesta de éxito
        echo json_encode(['success' => true, 'message' => 'Plato actualizado correctamente']);
    } else {
        // Si ocurrió un error durante la actualización, devolver un mensaje de error
        echo json_encode(['success' => false, 'message' => 'Error al actualizar el plato']);
    }
} else {
    // Si no se recibieron los datos esperados, devolver un mensaje de error
    echo json_encode(['success' => false, 'message' => 'Se esperaban datos del plato']);
}
?>
