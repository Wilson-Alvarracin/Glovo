<?php
// Verificar si se ha enviado un nombre de tipo de cocina por POST
if (isset($_POST['tipo_cocina'])) {
    // Incluir el archivo de conexión PDO
    require_once 'conexion.php';

    // Obtener el nombre del tipo de cocina
    $tipoCocina = $_POST['tipo_cocina'];

    // Validar que el nombre del tipo de cocina no esté vacío
    if (!empty($tipoCocina)) {
        try {
            // Insertar el nuevo tipo de cocina en la base de datos
            $sqlInsertTipoCocina = "INSERT INTO tbl_cocinas (cocina_nom) VALUES (:tipo_cocina)";
            $stmtInsertTipoCocina = $conn->prepare($sqlInsertTipoCocina);
            $stmtInsertTipoCocina->bindParam(':tipo_cocina', $tipoCocina);
            $stmtInsertTipoCocina->execute();

            // Devolver un mensaje de éxito
            echo json_encode(['success' => true, 'message' => 'El tipo de cocina se ha creado correctamente']);
        } catch (PDOException $e) {
            // Manejar errores
            echo json_encode(['success' => false, 'message' => 'Error al crear el tipo de cocina: ' . $e->getMessage()]);
        }
    } else {
        // Devolver un mensaje de error si el nombre del tipo de cocina está vacío
        echo json_encode(['success' => false, 'message' => 'El nombre del tipo de cocina no puede estar vacío']);
    }
} else {
    // Devolver un mensaje de error si no se proporciona un nombre de tipo de cocina
    echo json_encode(['success' => false, 'message' => 'No se ha proporcionado un nombre de tipo de cocina']);
}
?>
