<?php
require_once 'conexion.php';
$idUsuario = $_POST['id'];

try {
    // Iniciar una transacción
    $conn->beginTransaction();

    // Obtener los IDs de los restaurantes asociados al usuario
    $sqlSelectRestaurantes = "SELECT id_restaurante FROM tbl_restaurante WHERE id_usr_gerente = :idUsuario";
    $stmtSelectRestaurantes = $conn->prepare($sqlSelectRestaurantes);
    $stmtSelectRestaurantes->bindParam(':idUsuario', $idUsuario);
    $stmtSelectRestaurantes->execute();
    $restaurantes = $stmtSelectRestaurantes->fetchAll(PDO::FETCH_ASSOC);

    // Eliminar las filas de la tabla tbl_restu_cocina asociadas a cada restaurante
    foreach ($restaurantes as $restaurante) {
        $idRestaurante = $restaurante['id_restaurante'];
        $sqlDeleteCocina = "DELETE FROM tbl_restu_cocina WHERE id_restaurante = :idRestaurante";
        $stmtDeleteCocina = $conn->prepare($sqlDeleteCocina);
        $stmtDeleteCocina->bindParam(':idRestaurante', $idRestaurante);
        $stmtDeleteCocina->execute();
    }

    // Luego, eliminar las filas de la tabla tbl_platos asociadas a cada restaurante
    foreach ($restaurantes as $restaurante) {
        $idRestaurante = $restaurante['id_restaurante'];
        $sqlDeletePlatos = "DELETE FROM tbl_platos WHERE id_restaurante = :idRestaurante";
        $stmtDeletePlatos = $conn->prepare($sqlDeletePlatos);
        $stmtDeletePlatos->bindParam(':idRestaurante', $idRestaurante);
        $stmtDeletePlatos->execute();
    }

    // Luego, eliminar los restaurantes asociados al usuario
    $sqlDeleteRestaurantes = "DELETE FROM tbl_restaurante WHERE id_usr_gerente = :idUsuario";
    $stmtDeleteRestaurantes = $conn->prepare($sqlDeleteRestaurantes);
    $stmtDeleteRestaurantes->bindParam(':idUsuario', $idUsuario);
    $stmtDeleteRestaurantes->execute();

    // Finalmente, eliminar al usuario
    $sqlDeleteUsuario = "DELETE FROM tbl_usr WHERE id_usr = :idUsuario";
    $stmtDeleteUsuario = $conn->prepare($sqlDeleteUsuario);
    $stmtDeleteUsuario->bindParam(':idUsuario', $idUsuario);
    $stmtDeleteUsuario->execute();

    // Confirmar la transacción
    $conn->commit();

    // Verificar si se eliminó correctamente
    $rowCount = $stmtDeleteUsuario->rowCount();
    if ($rowCount > 0) {
        // Eliminación exitosa
        $response = array('success' => true, 'message' => 'Usuario eliminado correctamente.');
    } else {
        // No se pudo eliminar
        $response = array('success' => false, 'message' => 'No se pudo eliminar el usuario.');
    }
} catch (PDOException $e) {
    // Revertir la transacción en caso de error
    $conn->rollBack();
    $response = array('success' => false, 'message' => 'Error: ' . $e->getMessage());
}

// Devolver la respuesta en formato JSON
echo json_encode($response);
?>
