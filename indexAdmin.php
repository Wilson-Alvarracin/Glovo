<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD de Restaurantes</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./css/admin.css">
    <script src="./js/admin.js"></script>
</head>
<header>
    <h1>GLOVO Admin</h1>

    <!-- Header con botones para seleccionar la sección -->
    <div>
        <button onclick="mostrarContenido('restaurantes')">Restaurantes</button>
        <button onclick="mostrarContenido('usuarios')">Usuarios</button>
        <button onclick="mostrarContenido('platos')">Platos</button>
    </div>

</header>

<body>
    <!-- Contenido de Restaurantes -->
    <div id="restaurantes" class="hidden">
        <!-- Botón para añadir restaurante -->
        <button onclick="mostrarFormulario()">Añadir Restaurante</button>
        
        <!-- CRUD de Restaurantes -->
        <h2>Restaurantes</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Gerente</th> <!-- Cambiado de ID Gerente a Gerente -->
                <th>Tipo Comida</th>
                <th>Acciones</th>
            </tr>
<?php
// Incluir el archivo de conexión PDO
require_once './proc/conexion.php';

// Consulta SQL para obtener todos los restaurantes
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

$stmt = $conn->prepare($sql);
$stmt->execute();

// Mostrar datos de todos los restaurantes
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>".$row["id_restaurante"]."</td>";
    echo "<td>".$row["rest_nom"]."</td>";
    echo "<td>".$row["rest_desc"]."</td>";
    echo "<td>".$row["nombre_gerente"]."</td>";
    echo "<td>".$row["tipo_cocina"]."</td>"; // Mostrar el tipo de cocina
    echo "<td>
            <a href='javascript:void(0);' onclick='editarRestaurante(".$row["id_restaurante"].")'>Editar</a> | 
            <a href='javascript:void(0);' onclick='eliminarRestaurante(".$row["id_restaurante"].")'>Eliminar</a>
          </td>";
    echo "</tr>";
}
?>

        </table>
    </div>

<!-- Contenido de Usuarios -->
<div id="usuarios" class="hidden">
    <!-- Aquí va el contenido de Usuarios -->
    <h2>Usuarios</h2>
    <!-- Botón para añadir un nuevo usuario -->
    <button id="btnAgregarUsuario">Agregar Usuario</button>
    <!-- Tabla para mostrar la lista de usuarios -->
    <table id="tablaUsuarios">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo electrónico</th>
                <th>Contraseña</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Aquí se mostrarán los usuarios -->
        </tbody>
    </table>
</div>

<!-- Contenido de Platos -->
<div id="platos" class="hidden">
    <!-- Aquí va el contenido de Platos -->
    <h2>Platos</h2>
    <!-- Botón para agregar un nuevo plato -->
    <button id="btnAgregarPlato">Agregar Plato</button>
    <!-- Tabla para mostrar los platos -->
    <table id="tablaPlatos">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Restaurante</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Aquí se cargarán los platos -->
        </tbody>
    </table>
</div>
</html>
