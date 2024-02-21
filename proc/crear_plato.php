<?php
// Conectar a la base de datos
require_once 'conexion.php';

// Verificar si se reciben los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $idRestaurante = $_POST['idRestaurante']; // Obtener el id del restaurante desde el formulario

    // Ejemplo usando PDO (usando la conexión existente)
    try {
        // Preparar la consulta para insertar un nuevo plato
        $stmt = $conn->prepare('INSERT INTO tbl_platos (plato_descripcion, plato_precio, id_restaurante) VALUES (:nombre, :precio, :idRestaurante)');
        // Ejecutar la consulta con los datos recibidos
        $stmt->execute(array(
            ':nombre' => $nombre,
            ':precio' => $precio,
            ':idRestaurante' => $idRestaurante // Agregar el id del restaurante a la consulta
        ));

        // Enviar una respuesta al frontend
        echo json_encode(array('success' => true, 'message' => 'Plato creado exitosamente'));

    } catch(PDOException $e) {
        // Enviar una respuesta de error al frontend si ocurre algún problema
        echo json_encode(array('success' => false, 'message' => 'Error al crear el plato: ' . $e->getMessage()));
    }
} else {
    // Enviar una respuesta de error si la solicitud no es de tipo POST
    echo json_encode(array('success' => false, 'message' => 'Método de solicitud no válido'));
}
?>
