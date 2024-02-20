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
        } 
    },
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
                        // Enviar correo electrónico al gerente del restaurante
                        enviarCorreo(id);
                        
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

// Función para enviar correo electrónico al gerente del restaurante
function enviarCorreo(idRestaurante) {
    // Realizar la solicitud AJAX para obtener la información del gerente del restaurante
    $.ajax({
        url: './proc/obtener_info_gerente.php',
        method: 'POST',
        dataType: 'json',
        data: { idRestaurante: idRestaurante },
        success: function(response) {
            if (response.success) {
                // Datos del gerente
                var gerenteCorreo = response.correo;
                
                // Realizar la solicitud AJAX al servidor PHP para enviar el correo electrónico
                $.ajax({
                    url: './proc/enviar_correo.php',
                    method: 'POST',
                    dataType: 'json',
                    data: { destinatario: gerenteCorreo },
                    success: function(response) {
                        if (response.success) {
                            console.log('Correo electrónico enviado exitosamente');
                        } else {
                            console.error('Error al enviar el correo electrónico');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Hubo un error al procesar la solicitud para enviar el correo electrónico');
                    }
                });
            } else {
                console.error('Error al obtener la información del gerente');
            }
        },
        error: function(xhr, status, error) {
            console.error('Hubo un error al obtener la información del gerente');
        }
    });
}




















// ------------------------------------------------------- USUARIOS -------------------------------------

















$(document).ready(function () {
$('#btnAgregarUsuario').click(function () {
    const roles = ['Admin', 'User', 'Gerente'];
    let selectOptions = '';
    roles.forEach(function(rol) {
        selectOptions += `<option value="${rol}">${rol}</option>`;
    });

    Swal.fire({
        title: 'Agregar Usuario',
        html:
            '<form id="formAgregarUsuario">' +
            '<input id="nombreUsuario" class="swal2-input" placeholder="Nombre">' +
            '<input id="apellidoUsuario" class="swal2-input" placeholder="Apellido">' +
            '<input id="emailUsuario" class="swal2-input" placeholder="Correo electrónico">' +
            '<input type="password" id="passwordUsuario" class="swal2-input" placeholder="Contraseña">' +
            '<select id="rolUsuario" class="swal2-select">' +
            selectOptions +
            '</select>' +
            '</form>',
        showCancelButton: true,
        confirmButtonText: 'Guardar',
        cancelButtonText: 'Cancelar',
        preConfirm: () => {
            return {
                nombre: $('#nombreUsuario').val(),
                apellido: $('#apellidoUsuario').val(),
                email: $('#emailUsuario').val(),
                password: $('#passwordUsuario').val(),
                rol: $('#rolUsuario').val()
            };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: './proc/crear_usuario.php',
                type: 'POST',
                data: result.value,
                success: function(response) {
                    console.log('Respuesta del servidor:', response);
                    if (response.success) {
                        Swal.fire('Error', response.message, 'error');
                    } else {
                        Swal.fire('Usuario creado correctamente', response.message, 'success');
                        // Aquí puedes recargar la lista de usuarios o actualizarla con AJAX
                                    // Llama a la función para cargar la lista de usuarios al cargar la página
cargarUsuarios();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error en la solicitud AJAX:', error);
                    Swal.fire('Error', 'Hubo un error al procesar la solicitud.', 'error');
                }
            });
        }
    });

    // Evitar que el formulario se envíe al presionar Enter
    $('#formAgregarUsuario').submit(function(event) {
        event.preventDefault();
    });

});



// Función para cargar la lista de usuarios desde el servidor
function cargarUsuarios() {
    $.ajax({
        url: './proc/obtener_usuarios.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            const tbody = $('#tablaUsuarios tbody');
            tbody.empty();
            data.forEach(function(usuario) {
                const tr = $('<tr>');
                tr.append($('<td>').text(usuario.id));
                tr.append($('<td>').text(usuario.nombre));
                tr.append($('<td>').text(usuario.apellido));
                tr.append($('<td>').text(usuario.email));
                tr.append($('<td>').text(usuario.password)); // Se agrega el campo de contraseña
                tr.append($('<td>').text(usuario.rol)); // Se agrega el campo de rol
                const acciones = $('<td>');
                acciones.append($('<button>').text('Editar').click(function() {
                    // Aquí puedes mostrar SweetAlert con formulario para editar usuario
                    // Puedes seguir una estructura similar a la función para agregar usuario
                    Swal.fire('Editar Usuario', 'Aquí puedes mostrar formulario para editar usuario', 'info');
                }));
                acciones.append(' ');
                acciones.append($('<button>').text('Eliminar').click(function() {
                    // Aquí puedes mostrar SweetAlert para confirmar eliminación del usuario
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: 'Esta acción no se puede deshacer',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Sí, eliminar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Aquí puedes enviar la solicitud para eliminar el usuario desde tu backend
                            console.log('Eliminar usuario con ID:', usuario.id);
                            // Luego puedes recargar la lista de usuarios o actualizarla con AJAX
                        }
                    });
                }));
                tr.append(acciones);
                tbody.append(tr);
            });
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un error al cargar la lista de usuarios.'
            });
        }
    });
}

// Llama a la función para cargar la lista de usuarios al cargar la página
cargarUsuarios();
});





























// ----------------------------------------------------------------------------------------PLATOS -----------------------------------------------------------



















$(document).ready(function() {
// Función para cargar los platos
function cargarPlatos() {
    $.ajax({
        url: './proc/obtener_platos.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            const tbody = $('#tablaPlatos tbody');
            tbody.empty();
            data.forEach(function(plato) {
                const tr = $('<tr>');
                tr.append($('<td>').text(plato.id_plato));
                tr.append($('<td>').text(plato.plato_descripcion));
                tr.append($('<td>').text(plato.plato_precio));
                tr.append($('<td>').text(plato.nombre_restaurante)); // Mostrar el nombre del restaurante
                // Botones de edición y eliminación
                const acciones = $('<td>');
                const editarBtn = $('<button>').text('Editar').click(function() {
                    // Mostrar Sweet Alert para editar el plato
                    mostrarEditarPlatoAlert(plato);
                });
                const eliminarBtn = $('<button>').text('Eliminar').click(function() {
                    // Lógica para eliminar el plato aquí
                    eliminarPlato(plato.id_plato);
                });
                acciones.append(editarBtn).append(' ').append(eliminarBtn);
                tr.append(acciones);
                tbody.append(tr);
            });
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un error al cargar la lista de platos.'
            });
        }
    });
}

// Función para mostrar el Sweet Alert para editar el plato
function mostrarEditarPlatoAlert(plato) {
// Realizar una petición AJAX para obtener la lista de restaurantes
$.ajax({
    url: './proc/restaurante_plato.php', // Archivo PHP para obtener la lista de restaurantes
    method: 'GET',
    dataType: 'json',
    success: function(data) {
        const restaurantesOptions = data.map(restaurante => `<option value="${restaurante.id_restaurante}">${restaurante.rest_nom}</option>`).join('');
        Swal.fire({
            title: 'Editar Plato',
            html:
                `<input id="swal-input1" class="swal2-input" placeholder="Nombre" value="${plato.plato_descripcion}">` +
                `<input id="swal-input2" class="swal2-input" placeholder="Precio" value="${plato.plato_precio}">` +
                `<select id="swal-select" class="swal2-select">${restaurantesOptions}</select>`,
            showCancelButton: true,
            confirmButtonText: 'Guardar',
            cancelButtonText: 'Cancelar',
            preConfirm: () => {
                const nombre = Swal.getPopup().querySelector('#swal-input1').value;
                const precio = Swal.getPopup().querySelector('#swal-input2').value;
                const id_restaurante = Swal.getPopup().querySelector('#swal-select').value;
                if (!nombre || !precio || !id_restaurante) {
                    Swal.showValidationMessage('Nombre, Precio y Restaurante son campos requeridos');
                }
                return { nombre: nombre, precio: precio, id_restaurante: id_restaurante };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const { nombre, precio, id_restaurante } = result.value;
                // Enviar los datos actualizados al servidor
                actualizarPlato(plato.id_plato, nombre, precio, id_restaurante);
            }
        });
    },
    error: function(xhr, status, error) {
        console.error('Error en la solicitud AJAX:', error);
        Swal.fire('Error', 'Hubo un error al cargar la lista de restaurantes.', 'error');
    }
});
}


// Función para enviar los datos actualizados al servidor
function actualizarPlato(idPlato, nombre, precio) {
    $.ajax({
        url: './proc/actualizar_plato.php',
        method: 'POST',
        dataType: 'json',
        data: { id_plato: idPlato, nombre: nombre, precio: precio },
        success: function(response) {
            if (response.success) {
                Swal.fire('Error', response.message, 'error');
            } else {
                Swal.fire('Plato actualizado correctamente', response.message, 'success');
                // Recargar la lista de platos después de la actualización
                cargarPlatos();
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud AJAX:', error);
            Swal.fire('Error', 'Hubo un error al procesar la solicitud.', 'error');
        }
    });
}

// Función para eliminar un plato
function eliminarPlato(id) {
    // Implementar la lógica para eliminar un plato
}

// Cargar los platos al cargar la página
cargarPlatos();



    // Función para mostrar el formulario de creación de platos
    $('#btnAgregarPlato').click(function() {
        Swal.fire({
            title: 'Agregar Plato',
            html:
                '<input id="swal-input1" class="swal2-input" placeholder="Nombre">' +
                '<input id="swal-input2" class="swal2-input" placeholder="Precio">',
            showCancelButton: true,
            confirmButtonText: 'Guardar',
            cancelButtonText: 'Cancelar',
            preConfirm: () => {
                const nombre = Swal.getPopup().querySelector('#swal-input1').value;
                const precio = Swal.getPopup().querySelector('#swal-input2').value;
                if (!nombre || !precio) {
                    Swal.showValidationMessage('Nombre y Precio son campos requeridos');
                }
                return { nombre: nombre, precio: precio };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const { nombre, precio } = result.value;
                $.ajax({
                    url: './proc/crear_plato.php', 
                    method: 'POST',
                    dataType: 'json',
                    data: { nombre: nombre, precio: precio },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Error', response.message, 'error');
                        } else {
                            Swal.fire('Plato creado correctamente', response.message, 'success');
                            cargarPlatos();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la solicitud AJAX:', error);
                        Swal.fire('Error', 'Hubo un error al procesar la solicitud.', 'error');
                    }
                });
            }
        });
    });

    // Cargar los platos al cargar la página
    cargarPlatos();
});

