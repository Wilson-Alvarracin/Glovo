<?php
// Incluir el archivo de conexión PDO
require_once './proc/conexion.php';

// Obtener los valores de los filtros
$filtroNombreGerente = isset($_POST['filtroNombreGerente']) ? $_POST['filtroNombreGerente'] : '';
$filtroNombreRestaurante = isset($_POST['filtroNombreRestaurante']) ? $_POST['filtroNombreRestaurante'] : '';
$filtroTipoCocina = isset($_POST['filtroTipoCocina']) ? $_POST['filtroTipoCocina'] : '';

// Consulta SQL base para obtener todos los restaurantes con su tipo de cocina
$sql = "SELECT 
            r.id_restaurante,
            r.rest_nom,
            r.rest_desc,
            u.usr_nom AS nombre_gerente,
            c.cocina_nom AS tipo_cocina 
        FROM 
            tbl_restaurante r
        INNER JOIN 
            tbl_usr u ON r.id_usr_gerente = u.id_usr
        INNER JOIN 
            tbl_restu_cocina rc ON r.id_restaurante = rc.id_restaurante
        INNER JOIN 
            tbl_cocinas c ON rc.tipo_cocina = c.id_cocina";

// Aplicar filtros si se proporcionan
if (!empty($filtroNombreGerente)) {
    $sql .= " WHERE u.usr_nom LIKE '%$filtroNombreGerente%'";
}

if (!empty($filtroNombreRestaurante)) {
    $sql .= (strpos($sql, 'WHERE') !== false) ? " AND r.rest_nom LIKE '%$filtroNombreRestaurante%'" : " WHERE r.rest_nom LIKE '%$filtroNombreRestaurante%'";
}

if (!empty($filtroTipoCocina)) {
    $sql .= (strpos($sql, 'WHERE') !== false) ? " AND c.cocina_nom = '$filtroTipoCocina'" : " WHERE c.cocina_nom = '$filtroTipoCocina'";
}

// Preparar y ejecutar la consulta SQL
$stmt = $conn->prepare($sql);
$stmt->execute();

// Preparar un array para almacenar los resultados de la búsqueda
$resultados = array();

// Obtener los resultados de la consulta y almacenarlos en el array
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $resultados[] = $row;
}

// Devolver los resultados como JSON
echo json_encode(array('success' => true, 'data' => $resultados));

?>
