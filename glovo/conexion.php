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