<?php
session_start(); // Iniciar sesión

// // Verificar si el usuario está autenticado como gerente
// if (!isset($_SESSION['id_usr']) || $_SESSION['usr_rol'] !== 'gerente') {
//     // Si no está autenticado o no es gerente, redirigirlo a la página de inicio de sesión
//     header("Location: login.php");
//     exit;
// }

// Incluir el archivo de conexión a la base de datos
require_once "./proc/conexion.php";

// Obtener el ID del gerente de la sesión (en este caso, se asume que es 4)
$id_gerente = 4;

// Consulta SQL para obtener la información de los restaurantes asociados a este gerente
$sql = "SELECT id_restaurante, rest_nom, rest_header FROM tbl_restaurante WHERE id_usr_gerente = :id_gerente";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":id_gerente", $id_gerente, PDO::PARAM_INT);
$stmt->execute();
$restaurantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página del Gerente</title>
</head>
<body>
    <header>
        <!-- Mostrar imagen del encabezado -->
        <img src="ruta_a_imagen_del_encabezado.jpg" alt="Encabezado">
    </header>
    <div id="restaurantes">
        <!-- Mostrar botones para cada restaurante -->
        <?php foreach ($restaurantes as $restaurante): ?>
            <button onclick="mostrarContenido(<?php echo $restaurante['id_restaurante']; ?>)">
                <?php echo $restaurante['rest_nom']; ?>
            </button>
        <?php endforeach; ?>
    </div>
    <div id="contenidoRestaurante">
        <!-- Aquí se mostrará el contenido del restaurante seleccionado -->
    </div>

    <script>
        function mostrarContenido(idRestaurante) {
            // Aquí puedes usar AJAX para obtener el contenido del restaurante seleccionado y mostrarlo en la página
            // Por simplicidad, aquí solo se alerta el ID del restaurante seleccionado
            alert("Mostrar contenido del restaurante con ID: " + idRestaurante);
        }
    </script>
</body>
</html>
