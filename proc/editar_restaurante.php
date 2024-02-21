<?php
// Obtener los datos enviados por POST
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$idGerente = $_POST['idGerente'];
$idCocina = $_POST['idCocina']; // Nuevo campo para el ID del tipo de cocina

// Incluir el archivo de conexión PDO
require_once 'conexion.php';

try {
    // Comprobar si existe otro restaurante con el mismo nombre
    $sql = "SELECT COUNT(*) AS count FROM tbl_restaurante WHERE rest_nom = :nombre AND id_restaurante != :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $count = $row['count'];

    if ($count > 0) {
        // Si existe otro restaurante con el mismo nombre, devolver un error
        $response = array('success' => false, 'message' => 'Ya existe otro restaurante con el mismo nombre.');
    } else {
        // Si no hay ningún otro restaurante con el mismo nombre, realizar la actualización
        $sql = "UPDATE tbl_restaurante SET rest_nom = :nombre, rest_desc = :descripcion, id_usr_gerente = :idGerente WHERE id_restaurante = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':idGerente', $idGerente);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Actualizar la relación entre el restaurante y el tipo de cocina
        $sql_update_cocina = "UPDATE tbl_restu_cocina SET tipo_cocina = :idCocina WHERE id_restaurante = :id";
        $stmt_update_cocina = $conn->prepare($sql_update_cocina);
        $stmt_update_cocina->bindParam(':idCocina', $idCocina);
        $stmt_update_cocina->bindParam(':id', $id);
        $stmt_update_cocina->execute();

        // Verificar si se realizó la actualización correctamente
        $rowCount = $stmt->rowCount();
        if ($rowCount > 0) {
            // Actualización exitosa
            $response = array('success' => true, 'message' => 'Restaurante actualizado correctamente.');
        } else {
            // No se pudo actualizar
            $response = array('success' => false, 'message' => 'No se pudo actualizar el restaurante.');
        }
    }
} catch (PDOException $e) {
    // Error en la conexión o la consulta
    $response = array('success' => false, 'message' => 'Error: ' . $e->getMessage());
}

// Devolver la respuesta en formato JSON
echo json_encode($response);
?>
