<?php
// Incluir el archivo de conexión PDO
require_once 'conexion.php';

// Verificar si se recibió el ID del restaurante
if(isset($_POST['idRestaurante'])) {
    // Obtén el ID del restaurante desde la solicitud AJAX
    $idRestaurante = $_POST['idRestaurante'];

    try {
        // Consulta SQL para obtener la información del gerente del restaurante
        $sql = "SELECT u.usr_email 
                FROM tbl_restaurante r 
                INNER JOIN tbl_usr u ON r.id_usr_gerente = u.id_usr 
                WHERE r.id_restaurante = :idRestaurante";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':idRestaurante', $idRestaurante, PDO::PARAM_INT);
        $stmt->execute();

        // Obtener la dirección de correo electrónico del gerente
        $gerenteCorreo = $stmt->fetchColumn();

        // Devuelve la dirección de correo electrónico del gerente en formato JSON
        echo json_encode(array('success' => true, 'correo' => $gerenteCorreo));
    } catch(PDOException $e) {
        // Si ocurre algún error, devuelve un mensaje de error
        echo json_encode(array('success' => false, 'message' => 'Error al obtener información del gerente: ' . $e->getMessage()));
    }
} else {
    // Si no se proporcionó el ID del restaurante, devuelve un mensaje de error
    echo json_encode(array('success' => false, 'message' => 'ID del restaurante no recibido'));
}
?>
