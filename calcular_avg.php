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

session_start();

$restaurant_id = isset($_GET['restaurant_id']) ? $_GET['restaurant_id'] : 0;

// Consulta SQL para verificar si hay valoraciones
$checkSql = "SELECT COUNT(*) as total_valoraciones FROM tbl_valoracion WHERE id_rest = $restaurant_id";
$checkResult = $conn->query($checkSql);

// Verificar si hay resultados en la consulta de valoraciones
if ($checkResult !== false && $checkResult->num_rows > 0) {
    $totalValoraciones = $checkResult->fetch_assoc()['total_valoraciones'];
    
    // Verificar si hay valoraciones
    if ($totalValoraciones > 0) {
        // Consulta SQL para obtener la media de valoración
        $mediaSql = "SELECT ROUND(AVG(v.valoracion), 2) as media_valoracion FROM tbl_valoracion v WHERE v.id_rest = $restaurant_id";
        $mediaResult = $conn->query($mediaSql);

        // Verificar si hay resultados en la consulta de la media
        if ($mediaResult !== false && $mediaResult->num_rows > 0) {
            $media_valoracion = $mediaResult->fetch_assoc()['media_valoracion'];
            echo json_encode(array('media_valoracion' => $media_valoracion));
        } else {
            // Mostrar un mensaje de error si la consulta de la media falla
            $error_message = $mediaResult === false ? $conn->error : 'Error al obtener la media de valoración.';
            echo json_encode(array('error' => $error_message));
        }
    } else {
        // Mostrar 0 si no hay valoraciones
        echo json_encode(array('media_valoracion' => 0));
    }
} else {
    // Mostrar un mensaje de error si la consulta de valoraciones falla
    $error_message = $checkResult === false ? $conn->error : 'Error al verificar las valoraciones.';
    echo json_encode(array('error' => $error_message));
}

// Cerrar la conexión
$conn->close();
?>