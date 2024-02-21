<?php
// Incluir el archivo de conexión PDO
require_once 'conexion.php';

// Obtener ID del restaurante
$id_restaurante = $_POST['id'];

try {
    // Consulta SQL para obtener todos los tipos de cocina
    $sql = "SELECT id_cocina, cocina_nom FROM tbl_cocinas";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Obtener el tipo de cocina asociado al restaurante
    $sql_restaurante = "SELECT tipo_cocina FROM tbl_restu_cocina WHERE id_restaurante = :id_restaurante";
    $stmt_restaurante = $conn->prepare($sql_restaurante);
    $stmt_restaurante->bindParam(':id_restaurante', $id_restaurante);
    $stmt_restaurante->execute();
    $tipo_cocina_restaurante = $stmt_restaurante->fetch(PDO::FETCH_ASSOC)['tipo_cocina'];

    // Array para almacenar los tipos de cocina
    $tipos_cocina = array();

    // Recorrer los resultados y añadirlos al array
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $tipo_cocina = array(
            'id_cocina' => $row['id_cocina'],
            'cocina_nom' => $row['cocina_nom'],
            'selected' => ($tipo_cocina_restaurante == $row['id_cocina']) ? 'selected' : ''
        );
        $tipos_cocina[] = $tipo_cocina;
    }

    // Devolver los resultados como JSON
    echo json_encode(array("success" => true, "data" => $tipos_cocina));
    exit();
} catch (PDOException $e) {
    // Manejar errores de conexión
    echo json_encode(array("success" => false, "message" => "Error: " . $e->getMessage()));
    exit();
}
?>
