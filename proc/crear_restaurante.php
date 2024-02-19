<?php
// Verificar si se han enviado datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir el archivo de conexión PDO
    require_once 'conexion.php';

    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $idGerente = $_POST['idGerente'];

    try {
        // Verificar si ya existe un restaurante con el mismo nombre
        $stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_restaurante WHERE rest_nom = :nombre");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            // Si ya existe un restaurante con el mismo nombre, devuelve un mensaje de error
            echo json_encode(array("success" => false, "message" => "Ya existe un restaurante con el mismo nombre."));
            exit();
        }

        // Preparar la consulta SQL para insertar el restaurante
        $sql = "INSERT INTO tbl_restaurante (rest_nom, rest_desc, id_usr_gerente) VALUES (:nombre, :descripcion, :idGerente)";
        $stmt = $conn->prepare($sql);
        
        // Bind de los parámetros
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':idGerente', $idGerente);
        
        // Ejecutar la consulta
        $stmt->execute();

        // Verificar si se realizó la inserción correctamente
        if ($stmt->rowCount() > 0) {
            // Si la inserción fue exitosa, devuelve un mensaje de éxito
            echo json_encode(array("success" => true, "message" => "Restaurante creado correctamente."));
            exit();
        } else {
            // Si no se realizó la inserción correctamente, devuelve un mensaje de error
            echo json_encode(array("success" => false, "message" => "No se pudo agregar el restaurante, por favor intenta nuevamente."));
            exit();
        }
    } catch (PDOException $e) {
        // Manejar errores de inserción
        echo json_encode(array("success" => false, "message" => "Error: " . $e->getMessage()));
        exit();
    }
} else {
    // Si no se han enviado datos por POST, devuelve un mensaje de error
    echo json_encode(array("success" => false, "message" => "No se recibieron datos."));
    exit();
}
?>
