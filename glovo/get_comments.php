<?php
// Establecer conexión a la base de datos (reemplaza con tus credenciales)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_glovo";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$restaurant_id = isset($_GET['restaurant_id']) ? $_GET['restaurant_id'] : 0;

// Consulta SQL para obtener comentarios del restaurante específico
$sql = "SELECT u.usr_nom, v.valoracion, v.comentario FROM tbl_valoracion v
        INNER JOIN tbl_usr u ON v.id_usr = u.id_usr
        WHERE v.id_rest = $restaurant_id";


$result = $conn->query($sql);

// Verificar si hay resultados
if ($result) {
    if ($result->num_rows > 0) {
        // Mostrar los resultados en formato JSON
        $comments = array();
        while ($row = $result->fetch_assoc()) {
            $comments[] = array('user' => $row['usr_nom'], 'valoracion' => $row['valoracion'], 'comment' => $row['comentario']);
        }
        echo json_encode($comments);
    } else {
        // No hay comentarios
        echo json_encode(array('message' => 'No hay comentarios para este restaurante.'));
    }
} else {
    // Error en la consulta
    echo json_encode(array('error' => 'Error en la consulta: ' . $conn->error));
}

// Cerrar la conexión
$conn->close();
?>
