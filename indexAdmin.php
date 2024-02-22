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
<h1><img src="./img/glovo.jpg" alt="Glovo Logo"></h1>

    <!-- Header con botones para seleccionar la sección -->
    <div>
    <button class="boton-seleccion" onclick="mostrarContenido('restaurantes')">Restaurantes</button>
    <button class="boton-seleccion" onclick="mostrarContenido('usuarios')">Usuarios</button>
    <button class="boton-seleccion" onclick="mostrarContenido('platos')">Platos</button>
</div>

</header>

<body>
<!-- Contenido de Restaurantes -->
<div id="restaurantes" class="hidden">
    <!-- CRUD de Restaurantes -->
    <h2>Restaurantes</h2>
    <!-- Formulario para filtros -->

        <!-- Botón para añadir restaurante -->
        <button onclick="mostrarFormulario()">Añadir Restaurante</button>   
    <button onclick="crearTipoComida()">Crear tipo comida</button>  
    <br>
    <br>    
    
    <form method="GET" action="">
        <label for="nombreRestaurante">Nombre Restaurante:</label>
        <input type="text" id="nombreRestaurante" name="nombreRestaurante">
        <label for="nombreGerente">Nombre Gerente:</label> 
        <input type="text" id="nombreGerente" name="nombreGerente">
        <label for="tipoCocina">Tipo Cocina:</label>
        <input type="text" id="tipoCocina" name="tipoCocina">
        <button type="submit">Buscar</button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Gerente</th>
            <th>Tipo Comida</th>
            <th>Acciones</th>
        </tr>
        <?php
        // Incluir el archivo de conexión PDO
        require_once './proc/conexion.php';

        // Definir variables para los filtros (pueden provenir de un formulario)
        $nombreRestaurante = isset($_GET['nombreRestaurante']) ? $_GET['nombreRestaurante'] : '';
        $nombreGerente = isset($_GET['nombreGerente']) ? $_GET['nombreGerente'] : '';
        $tipoCocina = isset($_GET['tipoCocina']) ? $_GET['tipoCocina'] : '';

        // Consulta SQL para obtener restaurantes con filtros
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
                    (:nombreRestaurante = '' OR r.rest_nom LIKE :nombreRestaurante)
                    AND (:nombreGerente = '' OR u.usr_nom LIKE :nombreGerente)
                    AND (:tipoCocina = '' OR c.cocina_nom LIKE :tipoCocina)";

        $stmt = $conn->prepare($sql);

        // Asignar valores a los parámetros y ejecutar la consulta
        $stmt->execute([
            ':nombreRestaurante' => '%' . $nombreRestaurante . '%',
            ':nombreGerente' => '%' . $nombreGerente . '%',
            ':tipoCocina' => '%' . $tipoCocina . '%'
        ]);

        // Mostrar datos de los restaurantes filtrados
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>".$row["id_restaurante"]."</td>";
            echo "<td>".$row["rest_nom"]."</td>";
            echo "<td>".$row["rest_desc"]."</td>";
            echo "<td>".$row["nombre_gerente"]."</td>";
            echo "<td>".$row["tipo_cocina"]."</td>"; // Mostrar el tipo de cocina
            echo "<td>
            <button class='boton-formato' onclick='editarRestaurante(".$row["id_restaurante"].")'>Editar</button> 
            <button class='boton-formato' onclick='eliminarRestaurante(".$row["id_restaurante"].")'>Eliminar</button>
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
    <!-- Barra de filtro -->

        <!-- Botón para añadir un nuevo usuario -->
        <button id="btnAgregarUsuario">Agregar Usuario</button>
    <!-- Tabla para mostrar la lista de usuarios -->


    <form>
        <label for="filtroNombre">Filtrar por Nombre:</label>
        <input type="text" id="filtroNombre" />

        <label for="filtroCorreo">Filtrar por Correo:</label>
        <input type="text" id="filtroCorreo" />

        
        <label for="filtroRol">Filtrar por Rol:</label>
        <select id="filtroRol">
            <option value="">Todos</option>
            <option value="admin">Admin</option>
            <option value="user">User</option>
            <option value="gerente">Gerente</option>
        </select>
        <br>

    </form>
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
    <!-- Barra de filtro -->


        <!-- Botón para agregar un nuevo plato -->
        <button id="btnAgregarPlato">Agregar Plato</button>

    <form>
        <label for="filtroNombrePlato">Filtrar por Nombre:</label>
        <input type="text" id="filtroNombrePlato" />

        <label for="filtroPrecioMin">Precio Mínimo:</label>
        <input type="number" id="filtroPrecioMin" />

        <label for="filtroPrecioMax">Precio Máximo:</label>
        <input type="number" id="filtroPrecioMax" />

        <label for="filtroRestaurante">Filtrar por Restaurante:</label>
        <select id="filtroRestaurante">
            <option value="">Todos</option>
            <!-- Aquí se cargarán los restaurantes -->
        </select>
    </form>

    <!-- Tabla para mostrar los platos -->
    <table id="tablaPlatos">
        <thead>
            <tr>
                <th>ID</th>
                <th>Plato</th>
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
