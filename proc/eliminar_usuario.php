<?php
require_once 'conexion.php';

$idUsuario = $_POST['id'];

try {
    // Iniciar una transacción
    $conn->beginTransaction();

    // Obtener los ID de los restaurantes asociados al usuario
    $sqlRestaurantesUsuario = "SELECT id_restaurante FROM tbl_restaurante WHERE id_usr_gerente = :idUsuario";
    $stmtRestaurantesUsuario = $conn->prepare($sqlRestaurantesUsuario);
    $stmtRestaurantesUsuario->bindParam(':idUsuario', $idUsuario);
    $stmtRestaurantesUsuario->execute();
    $restaurantesUsuario = $stmtRestaurantesUsuario->fetchAll(PDO::FETCH_COLUMN);

    // Eliminar las valoraciones asociadas al usuario
    $sqlDeleteValoracionesUsuario = "DELETE FROM tbl_valoracion WHERE id_usr = :idUsuario";
    $stmtDeleteValoracionesUsuario = $conn->prepare($sqlDeleteValoracionesUsuario);
    $stmtDeleteValoracionesUsuario->bindParam(':idUsuario', $idUsuario);
    $stmtDeleteValoracionesUsuario->execute();

    // Eliminar las valoraciones asociadas a los restaurantes del usuario
    foreach ($restaurantesUsuario as $idRestaurante) {
        $sqlDeleteValoracionesRestaurante = "DELETE FROM tbl_valoracion WHERE id_rest = :idRestaurante";
        $stmtDeleteValoracionesRestaurante = $conn->prepare($sqlDeleteValoracionesRestaurante);
        $stmtDeleteValoracionesRestaurante->bindParam(':idRestaurante', $idRestaurante);
        $stmtDeleteValoracionesRestaurante->execute();
    }

    // Luego, eliminar los registros de tbl_restu_cocina asociados a los restaurantes del usuario
    $sqlDeleteRestuCocina = "DELETE rc FROM tbl_restu_cocina rc JOIN tbl_restaurante r ON rc.id_restaurante = r.id_restaurante WHERE r.id_usr_gerente = :idUsuario";
    $stmtDeleteRestuCocina = $conn->prepare($sqlDeleteRestuCocina);
    $stmtDeleteRestuCocina->bindParam(':idUsuario', $idUsuario);
    $stmtDeleteRestuCocina->execute();

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
