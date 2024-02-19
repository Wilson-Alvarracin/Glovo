<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD de Restaurantes</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        /* Estilo para ocultar los divs */
        .hidden {
            display: none;
        }

        /* Estilo para el encabezado */
        header {
            text-align: center;
            background-color: #ffc244; /* Color de fondo */
            padding: 20px 0; /* Espaciado interior */
        }

        /* Estilo para los botones del encabezado */
        header button {
            background-color: white; /* Color de fondo inicial */
            color: #000; /* Color del texto */
            border: 2px solid #000; /* Borde sólido */
            padding: 10px 20px; /* Espaciado interior */
            margin: 0 10px; /* Margen entre botones */
            cursor: pointer;
        }

        /* Estilo para los botones del encabezado cuando están activos */
        header button:active {
            background-color: green; /* Color de fondo cuando se pulsa */
        }

        /* Estilo para las tablas */
        table {
            margin: 0 auto; /* Centrar la tabla */
            border-collapse: collapse; /* Colapso de borde de tabla */
            width: 80%; /* Ancho de la tabla */
        }

        /* Estilo para las celdas de la tabla */
        th, td {
            border: 1px solid #000; /* Borde sólido */
            padding: 8px; /* Espaciado interior */
            text-align: left; /* Alineación del texto */
        }

        /* Estilo para las celdas de encabezado de la tabla */
        th {
            background-color: #ffc244; /* Color de fondo */
            color: white; /* Color del texto */
        }
    </style>
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
                <th>Acciones</th>
            </tr>
            <?php
            // Incluir el archivo de conexión PDO
            require_once './proc/conexion.php';

            try {
                // Consulta SQL para obtener los restaurantes
                $sql = "SELECT 
            r.id_restaurante,
            r.rest_nom,
            r.rest_desc,
            u.usr_nom AS nombre_gerente 
        FROM 
            tbl_restaurante r
        INNER JOIN 
            tbl_usr u ON r.id_usr_gerente = u.id_usr";

                $stmt = $conn->prepare($sql);
                $stmt->execute();

                // Mostrar datos de cada restaurante
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>".$row["id_restaurante"]."</td>";
                    echo "<td>".$row["rest_nom"]."</td>";
                    echo "<td>".$row["rest_desc"]."</td>";
                    echo "<td>".$row["nombre_gerente"]."</td>"; // Cambiado de ID Gerente a Gerente
                    echo "<td>
                            <a href='javascript:void(0);' onclick='editarRestaurante(".$row["id_restaurante"].")'>Editar</a> | 
                            <a href='javascript:void(0);' onclick='eliminarRestaurante(".$row["id_restaurante"].")'>Eliminar</a>
                        </td>";
                    echo "</tr>";
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            ?>
        </table>
    </div>

    <!-- Contenido de Usuarios -->
    <div id="usuarios" class="hidden">
        <!-- Aquí va el contenido de Usuarios -->
        <h2>Usuarios</h2>
        <!-- Puedes agregar el CRUD de Usuarios aquí -->
    </div>

    <!-- Contenido de Platos -->
    <div id="platos" class="hidden">
        <!-- Aquí va el contenido de Platos -->
        <h2>Platos</h2>
        <!-- Puedes agregar el CRUD de Platos aquí -->
    </div>

    <script>
    // Función para mostrar el contenido deseado y ocultar el resto
    function mostrarContenido(seccion) {
        // Obtener el div de la sección correspondiente
        var div = document.getElementById(seccion);
        
        // Verificar si el div está visible o no
        if (div.classList.contains('hidden')) {
            // Si está oculto, lo mostramos
            div.classList.remove('hidden');
        } else {
            // Si está visible, lo ocultamos
            div.classList.add('hidden');
        }
        
        // Ocultar los demás divs
        var divs = document.querySelectorAll('div[id$="_content"]');
        divs.forEach(function(item) {
            if (item.id !== seccion) {
                item.classList.add('hidden');
            }
        });
    }

    function mostrarFormulario() {
    // Realizar la solicitud AJAX para obtener los nombres de los gerentes
    $.ajax({
        url: './proc/obtener_nombres_gerentes.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // Crear opciones para el select
                var options = '';
                response.data.forEach(function(gerente) {
                    options += '<option value="' + gerente.id_usr + '">' + gerente.usr_nom + '</option>';
                });
                
                // Mostrar formulario con select en Swal
                Swal.fire({
                    title: 'Añadir Restaurante',
                    html:
                        '<input id="swal-input1" class="swal2-input" placeholder="Nombre">' +
                        '<input id="swal-input2" class="swal2-input" placeholder="Descripción">' +
                        '<select id="swal-select" class="swal2-select">' +
                        options +
                        '</select>',
                    showCancelButton: true,
                    confirmButtonText: 'Añadir',
                    cancelButtonText: 'Cancelar',
                    preConfirm: () => {
                        const nombre = Swal.getPopup().querySelector('#swal-input1').value;
                        const descripcion = Swal.getPopup().querySelector('#swal-input2').value;
                        const idGerente = Swal.getPopup().querySelector('#swal-select').value; // Obtener la ID del gerente seleccionado
                        if (!nombre || !idGerente) {
                            Swal.showValidationMessage('Nombre y Gerente son campos requeridos');
                        }
                        return { nombre: nombre, descripcion: descripcion, idGerente: idGerente }; // Enviar el nombre del restaurante
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const { nombre, descripcion, idGerente } = result.value;
                        
                        // Realizar la solicitud AJAX para crear el restaurante
                        $.ajax({
                            url: './proc/crear_restaurante.php',
                            method: 'POST',
                            dataType: 'json',
                            data: { nombre: nombre, descripcion: descripcion, idGerente: idGerente },
                            success: function(response) {
                                // Manejar la respuesta del servidor
                                if (response.success) {
                                    // Si la inserción fue exitosa, mostrar alerta de éxito
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Éxito',
                                        text: response.message
                                    }).then(() => {
                                        // Recargar la página después de cerrar la alerta
                                        location.reload();
                                    });
                                } else {
                                    // Si la inserción no fue exitosa, mostrar alerta de error
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: response.message
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                // Mostrar alerta si hay un error en la solicitud AJAX
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Hubo un error al procesar la solicitud.'
                                });
                            }
                        });
                    }
                });
            } else {
                // Mostrar mensaje de error si no se pudieron obtener los nombres de los gerentes
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });
            }
        },
        error: function(xhr, status, error) {
            // Mostrar alerta si hay un error en la solicitud AJAX para obtener los nombres de los gerentes
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un error al obtener los nombres de los gerentes.'
            });
        }
    });
}




function editarRestaurante(id) {
    // Obtener detalles del restaurante por su ID
    $.ajax({
        url: './proc/obtener_restaurante.php',
        method: 'POST',
        dataType: 'json',
        data: { id: id },
        success: function(response) {
            // Mostrar Sweet Alert con los datos del restaurante y campos de edición
            Swal.fire({
                title: 'Editar Restaurante',
                html:
                    '<input id="swal-input1" class="swal2-input" placeholder="Nombre" value="' + response.rest_nom + '">' +
                    '<input id="swal-input2" class="swal2-input" placeholder="Descripción" value="' + response.rest_desc + '">' +
                    '<select id="swal-select" class="swal2-select">' + // Cambiado a un select
                    '</select>',
                showCancelButton: true,
                confirmButtonText: 'Aplicar cambios',
                cancelButtonText: 'Cancelar',
                preConfirm: () => {
                    const nombre = Swal.getPopup().querySelector('#swal-input1').value;
                    const descripcion = Swal.getPopup().querySelector('#swal-input2').value;
                    const idGerente = Swal.getPopup().querySelector('#swal-select').value;
                    if (!nombre || !idGerente) {
                        Swal.showValidationMessage('Nombre y ID Gerente son campos requeridos');
                    }
                    return { nombre: nombre, descripcion: descripcion, idGerente: idGerente };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const { nombre, descripcion, idGerente } = result.value;

                    // Realizar la solicitud AJAX para actualizar el restaurante
                    $.ajax({
                        url: './proc/editar_restaurante.php',
                        method: 'POST',
                        dataType: 'json',
                        data: { id: id, nombre: nombre, descripcion: descripcion, idGerente: idGerente },
                        success: function(response) {
                            // Mostrar alerta de éxito o error
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: response.message
                                }).then(() => {
                                    // Recargar la página después de cerrar la alerta
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Hubo un error al procesar la solicitud.'
                            });
                        }
                    });
                }
            });

            // Llenar el select con los nombres de los gerentes y seleccionar el correspondiente
            $.ajax({
                url: './proc/obtener_nombres_gerentes.php',
                method: 'GET',
                dataType: 'json',
                success: function(gerentes) {
                    if (gerentes.success) {
                        var select = document.getElementById('swal-select');
                        gerentes.data.forEach(function(gerente) {
                            var option = document.createElement('option');
                            option.value = gerente.id_usr;
                            option.text = gerente.usr_nom;
                            if (gerente.id_usr === response.id_usr_gerente) {
                                option.selected = true; // Seleccionar el gerente correspondiente
                            }
                            select.appendChild(option);
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: gerentes.message
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un error al obtener los nombres de los gerentes.'
                    });
                }
            });
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un error al procesar la solicitud.'
            });
        }
    });
}



    // Función para eliminar un restaurante
    function eliminarRestaurante(id) {
        // Mostrar confirmación antes de eliminar
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción no se puede revertir',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Realizar la solicitud AJAX para eliminar el restaurante
                $.ajax({
                    url: './proc/eliminar_restaurante.php',
                    method: 'POST',
                    dataType: 'json',
                    data: { id: id },
                    success: function(response) {
                        // Mostrar alerta de éxito o error
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Éxito',
                                text: response.message
                            }).then(() => {
                                // Recargar la página después de cerrar la alerta
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un error al procesar la solicitud.'
                        });
                    }
                });
            }
        });
    }
</script>

</html>
