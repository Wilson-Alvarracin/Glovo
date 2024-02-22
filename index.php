<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "db_glovo";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verifica si el usuario ha iniciado sesión
if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
    $email = $_SESSION['email'];
    $password = $_SESSION['password'];

    echo "<p>Welcome, $email!</p>";
}

// Fetch all restaurants
$restaurants_query = "SELECT id_restaurante, rest_nom, rest_desc FROM tbl_restaurante";
$restaurants_result = $conn->query($restaurants_query);

if ($restaurants_result->num_rows > 0) {
    while ($restaurant = $restaurants_result->fetch_assoc()) {
        echo "<p><a href='platos.php?restaurant_id={$restaurant['id_restaurante']}'>{$restaurant['rest_nom']}</a> - {$restaurant['rest_desc']}</p>";
    }
} else {
    echo "<p>No restaurants available.</p>";
}
echo '<a href="cerrar_sesion.php" class="btn btn-danger">Cerrar Sesión</a>';
$conn->close();
?>
