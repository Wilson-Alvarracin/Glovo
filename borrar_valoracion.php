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

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_user'])) {
    header("Location: index.php"); // Redireccionar a la página de inicio de sesión si no está autenticado
    exit();
}

// Obtener el ID de la valoración a borrar desde la solicitud GET
$valoracion_id = isset($_GET['valoracion_id']) ? $_GET['valoracion_id'] : 0;

// Verificar si se proporcionó un ID de valoración válido
if ($valoracion_id > 0) {
    // Realizar la eliminación en la base de datos (ajusta según tu estructura)
    $sql_delete = "DELETE FROM tbl_valoracion WHERE id_valoracion = $valoracion_id";
    $result_delete = $conn->query($sql_delete);

    if ($result_delete) {
        // Éxito en el borrado
        echo "Valoración borrada con éxito.";
    } else {
        // Error en el borrado
        echo "Error al borrar la valoración: " . $conn->error;
    }
} else {
    // ID de valoración no válido
    echo "ID de valoración no válido.";
}

// Cerrar la conexión
$conn->close();
?>
