<?php
// Incluir el archivo de conexión PDO
require_once 'conexion.php';

try {
    // Consulta SQL para obtener los nombres de los gerentes
    $sql = "SELECT id_usr, usr_nom FROM tbl_usr WHERE usr_rol = 'gerente'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    // Array para almacenar los nombres de los gerentes
    $nombresGerentes = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $nombresGerentes[] = $row;
    }
    
    // Devolver los nombres de los gerentes en formato JSON
    echo json_encode(['success' => true, 'data' => $nombresGerentes]);
} catch (PDOException $e) {
    // Manejar cualquier error de la base de datos
    echo json_encode(['success' => false, 'message' => 'Error al obtener los nombres de los gerentes: ' . $e->getMessage()]);
}
?>
