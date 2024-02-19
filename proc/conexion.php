<?php
// Credenciales de la base de datos
$servername = "localhost";
$username = "root"; // Reemplaza 'tu_usuario' con tu nombre de usuario
$password = ""; // Reemplaza 'tu_contraseña' con tu contraseña
$database = "db_glovo";

try {
    // Crear conexión PDO
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    
    // Configurar el modo de error para que PDO arroje excepciones
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch(PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
