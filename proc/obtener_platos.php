<?php
// Incluir el archivo de conexión PDO
require_once 'conexion.php';

try {
    // Inicializar la consulta SQL base para obtener todos los platos con el nombre del restaurante
    $sql_platos = "SELECT p.id_plato, p.plato_nombre, p.plato_precio, r.rest_nom AS nombre_restaurante
                FROM tbl_platos p
                INNER JOIN tbl_restaurante r ON p.id_restaurante = r.id_restaurante";

    // Inicializar un array para almacenar los valores de los filtros
    $placeholders = array();

    // Inicializar la parte de la consulta SQL para los filtros
    $where_clause = "";

    // Verificar si se proporcionó un nombre de plato como filtro
    if (isset($_GET['nombrePlato']) && $_GET['nombrePlato'] !== '') {
        $where_clause .= " WHERE p.plato_nombre LIKE ?";
        $placeholders[] = '%' . $_GET['nombrePlato'] . '%';
    }

    // Verificar si se proporcionó un precio mínimo como filtro
    if (isset($_GET['precioMin']) && $_GET['precioMin'] !== '') {
        $where_clause .= $where_clause === "" ? " WHERE" : " AND";
        $where_clause .= " p.plato_precio >= ?";
        $placeholders[] = $_GET['precioMin'];
    }

    // Verificar si se proporcionó un precio máximo como filtro
    if (isset($_GET['precioMax']) && $_GET['precioMax'] !== '') {
        $where_clause .= $where_clause === "" ? " WHERE" : " AND";
        $where_clause .= " p.plato_precio <= ?";
        $placeholders[] = $_GET['precioMax'];
    }

    // Verificar si se proporcionó un restaurante como filtro
    if (isset($_GET['idRestaurante']) && $_GET['idRestaurante'] !== '') {
        $where_clause .= $where_clause === "" ? " WHERE" : " AND";
        $where_clause .= " p.id_restaurante = ?";
        $placeholders[] = $_GET['idRestaurante'];
    }

    // Combinar la consulta base con la parte de los filtros
    $sql_platos .= $where_clause;

    // Preparar la consulta SQL
    $stmt_platos = $conn->prepare($sql_platos);

    // Ejecutar la consulta con los valores de los filtros
    $stmt_platos->execute($placeholders);

    // Inicializar un array para almacenar los platos
    $platos = array();

    // Agregar cada plato al array
    while ($row_plato = $stmt_platos->fetch(PDO::FETCH_ASSOC)) {
        $platos[] = $row_plato;
    }

    // Devolver los platos en formato JSON
    echo json_encode($platos);
} catch(PDOException $e) {
    // Enviar una respuesta de error si hay un problema con la consulta
    echo json_encode(array('error' => 'Error al obtener los platos: ' . $e->getMessage()));
}
?>
