<?php
// Incluir el archivo de conexión PDO
require_once 'conexion.php';

// Consulta SQL para obtener todos los platos con el nombre del restaurante
$sql_platos = "SELECT p.id_plato, p.plato_descripcion, p.plato_precio, r.rest_nom AS nombre_restaurante
                FROM tbl_platos p
                INNER JOIN tbl_restaurante r ON p.id_restaurante = r.id_restaurante";
$stmt_platos = $conn->prepare($sql_platos);
$stmt_platos->execute();

// Inicializar un array para almacenar los platos
$platos = array();

// Agregar cada plato al array
while ($row_plato = $stmt_platos->fetch(PDO::FETCH_ASSOC)) {
    $platos[] = $row_plato;
}

// Devolver los platos en formato JSON
echo json_encode($platos);
?>
