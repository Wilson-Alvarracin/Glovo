<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página del Gerente</title>
    <style>
        table {
            width: 80%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
    <!-- Incluir SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
    <header>
        <!-- Mostrar imagen del encabezado -->
        <img src="ruta_a_imagen_del_encabezado.jpg" alt="Encabezado">
    </header>
    <div id="restaurantes">
        <!-- Mostrar botones para cada restaurante -->
        <?php
        session_start(); // Iniciar sesión

        // Incluir el archivo de conexión a la base de datos
        require_once "./proc/conexion.php";

        // Obtener el ID del gerente de la sesión (en este caso, se asume que es 11)
        $id_gerente = 11;

        // Consulta SQL para obtener la información de los restaurantes asociados a este gerente
        $sql = "SELECT id_restaurante, rest_nom, rest_header FROM tbl_restaurante WHERE id_usr_gerente = :id_gerente";
        $stmt = $conn->prepare($sql); // Cambiar $pdo a $conn
        $stmt->bindParam(":id_gerente", $id_gerente, PDO::PARAM_INT);
        $stmt->execute();
        $restaurantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($restaurantes as $restaurante) {
            echo "<button onclick='mostrarDetallesRestaurante(" . $restaurante['id_restaurante'] . ")'>" . $restaurante['rest_nom'] . "</button>";
        }
        ?>
    </div>
    <div id="detallesRestaurante">
        <!-- Aquí se mostrarán los detalles del restaurante seleccionado -->
        <?php
        // Verificar si se ha enviado un ID de restaurante y mostrar detalles si es así
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            // Obtener el ID del restaurante
            $id_restaurante = $_GET['id'];

            // Consulta SQL para obtener los detalles del restaurante
            $sql = "SELECT * FROM tbl_restaurante WHERE id_restaurante = :id_restaurante";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":id_restaurante", $id_restaurante, PDO::PARAM_INT);
            $stmt->execute();
            $restaurante = $stmt->fetch(PDO::FETCH_ASSOC);

            // Mostrar los detalles del restaurante en una tabla con botones de editar y eliminar
            echo "<h2>Detalles del Restaurante</h2>";
            echo "<table>";
            echo "<tr><th>Nombre</th><th>Descripción</th><th>Encabezado</th><th>Logo</th><th>Acciones</th></tr>";
            echo "<tr><td>" . $restaurante['rest_nom'] . "</td><td>" . $restaurante['rest_desc'] . "</td><td>" . $restaurante['rest_header'] . "</td><td>" . $restaurante['rest_logo'] . "</td><td><button onclick='editarRestaurante(" . $restaurante['id_restaurante'] . ")'>Editar</button> <button onclick='eliminarRestaurante(" . $restaurante['id_restaurante'] . ")'>Eliminar</button></td></tr>";
            echo "</table>";
        }
        ?>
    </div>

    <div id="valoracionesRestaurante">
        <!-- Aquí se mostrarán las valoraciones del restaurante seleccionado -->
        <?php
        // Verificar si se ha enviado un ID de restaurante y mostrar valoraciones si es así
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            // Obtener el ID del restaurante
            $id_restaurante = $_GET['id'];

            // Consulta SQL para obtener las valoraciones del restaurante
            $sql = "SELECT * FROM tbl_valoracion WHERE id_rest = :id_restaurante";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":id_restaurante", $id_restaurante, PDO::PARAM_INT);
            $stmt->execute();
            $valoraciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Mostrar las valoraciones del restaurante en una tabla
            echo "<h2>Valoraciones del Restaurante</h2>";
            echo "<table>";
            echo "<tr><th>Valoración</th><th>Comentario</th></tr>";
            foreach ($valoraciones as $valoracion) {
                echo "<tr><td>" . $valoracion['valoracion'] . "</td><td>" . $valoracion['comentario'] . "</td></tr>";
            }
            echo "</table>";
        }
        ?>
    </div>

    <div id="platosRestaurante">
        <!-- Aquí se mostrarán los platos del restaurante seleccionado -->
        <?php
        // Verificar si se ha enviado un ID de restaurante y mostrar platos si es así
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            // Obtener el ID del restaurante
            $id_restaurante = $_GET['id'];

            // Consulta SQL para obtener los platos del restaurante
            $sql = "SELECT * FROM tbl_platos WHERE id_restaurante = :id_restaurante";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":id_restaurante", $id_restaurante, PDO::PARAM_INT);
            $stmt->execute();
            $platos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Mostrar los platos del restaurante en una tabla con botones de editar y eliminar
            echo "<h2>Platos del Restaurante</h2>";
            echo "<table>";
            echo "<tr><th>Nombre</th><th>Precio</th><th>Descripción</th><th>Imagen</th><th>Acciones</th></tr>";
            foreach ($platos as $plato) {
                echo "<tr><td>" . $plato['plato_nombre'] . "</td><td>" . $plato['plato_precio'] . "</td><td>" . $plato['plato_descripcion'] . "</td><td>" . $plato['plato_imagen'] . "</td><td><button onclick='editarPlato(" . $plato['id_plato'] . ")'>Editar</button> <button onclick='eliminarPlato(" . $plato['id_plato'] . ")'>Eliminar</button></td></tr>";
            }
            echo "</table>";
            echo "<button onclick='agregarPlato(" . $id_restaurante . ")'>Agregar Nuevo Plato</button>";
        }
        ?>
    </div>

    <script>
        function mostrarDetallesRestaurante(idRestaurante) {
            window.location.href = "indexGerente.php?id=" + idRestaurante;
        }

        function editarRestaurante(idRestaurante) {
    // Realizar una petición AJAX para obtener los datos del restaurante
    // y luego mostrar el formulario de edición
    $.ajax({
        url: './proc/obtener_datos_restaurante.php', // URL que devuelve los datos del restaurante
        type: 'GET',
        data: {id: idRestaurante},
        success: function(response) {
            // Parsear la respuesta JSON para obtener los datos del restaurante
            var restaurante = JSON.parse(response);

            // Crear el formulario HTML para editar el restaurante
            var formHtml = `
                <form id="editarRestauranteForm">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="${restaurante.nombre}" required><br>
                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" required>${restaurante.descripcion}</textarea><br>
                    <label for="encabezado">Encabezado:</label>
                    <input type="file" id="encabezado" name="encabezado"><br>
                    <label for="logo">Logo:</label>
                    <input type="file" id="logo" name="logo"><br>
                    <input type="submit" value="Guardar Cambios">
                </form>
            `;

            // Mostrar la alerta de SweetAlert con el formulario de edición
            Swal.fire({
                title: 'Editar Restaurante',
                html: formHtml,
                showCancelButton: true,
                showConfirmButton: false,
                cancelButtonText: 'Cancelar'
            });

            // Capturar el envío del formulario
            $('#editarRestauranteForm').submit(function(event) {
                event.preventDefault(); // Evitar el envío del formulario normal

                // Obtener los datos del formulario
                var formData = new FormData(this);

                // Agregar el ID del restaurante al FormData
                formData.append('idRestaurante', idRestaurante);

                // Realizar una petición AJAX para actualizar los datos del restaurante
                $.ajax({
                    url: 'actualizar_restaurante.php', // URL para actualizar los datos del restaurante
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // Mostrar mensaje de éxito con SweetAlert
                        Swal.fire({
                            title: 'Éxito',
                            text: 'Los datos del restaurante han sido actualizados correctamente.',
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        }).then((result) => {
                            // Recargar la página después de cerrar la alerta
                            location.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        // Mostrar mensaje de error con SweetAlert
                        Swal.fire({
                            title: 'Error',
                            text: 'Se produjo un error al actualizar los datos del restaurante.',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }
                });
            });
        },
        error: function(xhr, status, error) {
            // Mostrar mensaje de error si falla la petición AJAX
            Swal.fire({
                title: 'Error',
                text: 'No se pudieron obtener los datos del restaurante.',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
        }
    });
}


        function eliminarRestaurante(idRestaurante) {
            // Mostrar alerta de SweetAlert para eliminar restaurante
            Swal.fire({
                title: 'Eliminar Restaurante',
                text: 'Eliminar restaurante con ID: ' + idRestaurante,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Aquí puedes realizar la lógica para eliminar el restaurante si el usuario confirma
                    // Por ejemplo, puedes hacer una solicitud AJAX para enviar la solicitud al servidor
                    // y luego recargar la página
                    // window.location.reload();
                }
            });
        }
        
        function editarPlato(idPlato) {
    // Realizar una petición AJAX para obtener los datos del plato
    $.ajax({
        url: './proc/obtener_datos_plato.php', // URL que devuelve los datos del plato
        type: 'GET',
        data: {id: idPlato},
        success: function(response) {
            // Parsear la respuesta JSON para obtener los datos del plato
            var plato = JSON.parse(response);

            // Crear el formulario HTML para editar el plato y mostrar la información actual del plato
            var formHtml = `
                <form id="editarPlatoForm" style="max-width: 400px; margin: 20px auto;">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="${plato.nombre}" required style="width: 100%; margin-bottom: 10px;"><br>
                    <label for="precio">Precio:</label>
                    <input type="text" id="precio" name="precio" value="${plato.precio}" required style="width: 100%; margin-bottom: 10px;"><br>
                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" required style="width: 100%; margin-bottom: 10px;">${plato.descripcion}</textarea><br>
                    <label for="imagen">Imagen:</label>
                    <input type="file" id="imagen" name="imagen" style="margin-bottom: 10px;"><br>
                    <input type="hidden" id="idPlato" name="idPlato" value="${idPlato}">
                    <input type="submit" value="Guardar Cambios" style="background-color: #4CAF50; color: white; padding: 10px 15px; border: none; cursor: pointer;">
                </form>
            `;

            // Mostrar la alerta de SweetAlert con el formulario de edición
            Swal.fire({
                title: 'Editar Plato',
                html: formHtml,
                showCancelButton: true,
                showConfirmButton: false,
                cancelButtonText: 'Cancelar',
                customClass: {
                    popup: 'custom-popup-class' // Clase personalizada para el contenedor de la alerta
                }
            });

            // Capturar el envío del formulario
            $('#editarPlatoForm').submit(function(event) {
                event.preventDefault(); // Evitar el envío del formulario normal

                // Obtener los datos del formulario
                var formData = new FormData(this);

                // Realizar una petición AJAX para actualizar los datos del plato
                $.ajax({
                    url: 'actualizar_plato.php', // URL para actualizar los datos del plato
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // Mostrar mensaje de éxito con SweetAlert
                        Swal.fire({
                            title: 'Éxito',
                            text: 'Los datos del plato han sido actualizados correctamente.',
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        }).then((result) => {
                            // Recargar la página después de cerrar la alerta
                            location.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        // Mostrar mensaje de error con SweetAlert
                        Swal.fire({
                            title: 'Error',
                            text: 'Se produjo un error al actualizar los datos del plato.',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }
                });
            });
        },
        error: function(xhr, status, error) {
            // Mostrar mensaje de error si falla la petición AJAX
            Swal.fire({
                title: 'Error',
                text: 'No se pudieron obtener los datos del plato.',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
        }
    });
}



        function eliminarPlato(idPlato) {
            // Mostrar alerta de SweetAlert para eliminar plato
            Swal.fire({
                title: 'Eliminar Plato',
                text: 'Eliminar plato con ID: ' + idPlato,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Aquí puedes realizar la lógica para eliminar el plato si el usuario confirma
                    // Por ejemplo, puedes hacer una solicitud AJAX para enviar la solicitud al servidor
                    // y luego recargar la página
                    // window.location.reload();
                }
            });
        }

        function agregarPlato(idRestaurante) {
            // Mostrar alerta de SweetAlert para agregar plato
            Swal.fire({
                title: 'Agregar Nuevo Plato',
                text: 'Agregar nuevo plato para restaurante con ID: ' + idRestaurante,
                icon: 'info',
                confirmButtonText: 'Ok'
            });
        }
    </script>
</body>
</html>