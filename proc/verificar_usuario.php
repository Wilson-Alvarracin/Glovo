<?php
require_once 'conexion.php';

$idUsuario = $_POST['id'];

// Verificar si el usuario es un gerente y si tiene restaurantes asociados
$sql = "SELECT COUNT(*) AS countGerente, SUM(CASE WHEN id_restaurante IS NOT NULL THEN 1 ELSE 0 END) AS countRestaurantes FROM tbl_restaurante WHERE id_usr_gerente = :idUsuario";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':idUsuario', $idUsuario);
$stmt->execute();
$resultado = $stmt->fetch(PDO::FETCH_ASSOC);

// Determinar si el usuario es un gerente y si tiene restaurantes asociados
$esGerente = $resultado['countGerente'] > 0;
$tieneRestaurantes = $resultado['countRestaurantes'] > 0;

// Devolver la respuesta en formato JSON
$response = array(
    'success' => true,
    'isGerente' => $esGerente,
    'hasRestaurantes' => $tieneRestaurantes
);
echo json_encode($response);
?>
