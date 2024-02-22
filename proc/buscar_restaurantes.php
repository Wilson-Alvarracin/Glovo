<?php
// Incluir el archivo de conexión PDO
require_once 'conexion.php';

try {
    // Obtener los filtros de búsqueda
    $filtroNombreGerente = isset($_POST['filtroNombreGerente']) ? $_POST['filtroNombreGerente'] : '';
    $filtroNombreRestaurante = isset($_POST['filtroNombreRestaurante']) ? $_POST['filtroNombreRestaurante'] : '';
    $filtroTipoCocina = isset($_POST['filtroTipoCocina']) ? $_POST['filtroTipoCocina'] : '';

    // Consulta SQL para buscar restaurantes según los filtros aplicados
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
                tbl_cocinas c ON rc.tipo_cocina = c.id_cocina
            WHERE 
                (:filtroNombreGerente = '' OR u.usr_nom LIKE :filtroNombreGerente) AND
                (:filtroNombreRestaurante = '' OR r.rest_nom LIKE :filtroNombreRestaurante) AND
                (:filtroTipoCocina = '' OR c.id_cocina = :filtroTipoCocina)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':filtroNombreGerente', '%' . $filtroNombreGerente . '%');
    $stmt->bindValue(':filtroNombreRestaurante', '%' . $filtroNombreRestaurante . '%');
    $stmt->bindValue(':filtroTipoCocina', $filtroTipoCocina);
    $stmt->execute();

    // Obtener los resultados como un array asociativo
    $restaurantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Devolver los resultados en formato JSON
    echo json_encode(['success' => true, 'data' => $restaurantes]);
} catch (PDOException $e) {
    // Manejar errores
    echo json_encode(['success' => false, 'message' => 'Error al buscar restaurantes: ' . $e->getMessage()]);
}
?>
