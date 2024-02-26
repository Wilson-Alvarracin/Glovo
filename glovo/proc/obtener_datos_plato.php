<?php
// Incluir el archivo de conexión a la base de datos
require_once "conexion.php";

// Verificar si se recibió el ID del plato
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_plato = $_GET['id'];

    try {
        // Consulta para obtener los datos del plato
        $stmt = $conn->prepare("SELECT * FROM tbl_platos WHERE id_plato = :id_plato");
        $stmt->bindParam(":id_plato", $id_plato, PDO::PARAM_INT);
        $stmt->execute();
        $plato = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si se encontró el plato
        if($plato) {
            // Devolver los datos del plato como JSON
            echo json_encode($plato);
        } else {
            // Si el plato no se encontró, devolver un mensaje de error
            echo json_encode(array('error' => 'Plato no encontrado'));
        }
    } catch(PDOException $e) {
        // Si hay un error en la consulta, devolver un mensaje de error
        echo json_encode(array('error' => 'Error al obtener los datos del plato: ' . $e->getMessage()));
    }
} else {
    // Si no se proporcionó un ID válido, devolver un mensaje de error
    echo json_encode(array('error' => 'ID de plato no válido'));
}
?>
