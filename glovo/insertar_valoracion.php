<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_glovo";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener datos de la solicitud POST
$valoracion = isset($_POST['valoracion']) ? str_replace(',', '.', $_POST['valoracion']) : 0;
$comentario = isset($_POST['comentario']) ? $_POST['comentario'] : '';
$restauranteID = isset($_POST['restaurante_id']) ? $_POST['restaurante_id'] : 0;
$id_usr = isset($_POST['id_usr']) ? $_POST['id_usr'] : 0;

// Validar y realizar la inserción en la base de datos
if ($valoracion >= 1 && $valoracion <= 5 && $restauranteID > 0 && $id_usr > 0 && $comentario != '') {
    // Verificar si el usuario ya ha realizado una valoración para este restaurante
    $check_query = "SELECT COUNT(*) as count FROM tbl_valoracion WHERE id_usr = ? AND id_rest = ?";
    $check_stmt = $conn->prepare($check_query);

    if ($check_stmt) {
        $check_stmt->bind_param('ii', $id_usr, $restauranteID);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        $row = $check_result->fetch_assoc();
        $existing_count = $row['count'];

        $check_stmt->close();

        // Si ya existe una valoración, mostrar un mensaje de error
        if ($existing_count > 0) {
            echo json_encode(['success' => false, 'message' => 'Ya has realizado una valoración para este restaurante.']);
            exit();
        }
    }

    // Insertar la nueva valoración
    $insert_query = "INSERT INTO tbl_valoracion (id_rest, valoracion, comentario, id_usr) VALUES (?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_query);

    if ($insert_stmt) {
        // Vincular parámetros
        $insert_stmt->bind_param('idsi', $restauranteID, $valoracion, $comentario, $id_usr);

        // Ejecutar la consulta
        if ($insert_stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Valoración insertada con éxito']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al ejecutar la consulta: ' . $insert_stmt->error]);
        }

        // Cerrar la consulta preparada
        $insert_stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta: ' . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Datos de valoración inválidos']);
}

$conn->close();
?>
