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

// Al cargar la página, mostrar inicialmente la sección de restaurantes
window.addEventListener('load', function() {
    mostrarContenido('restaurantes');
});




function crearTipoComida() {
    Swal.fire({
        title: 'Crear Nuevo Tipo de Cocina',
        html: '<input id="tipoCocinaInput" class="swal2-input" placeholder="Nombre del Tipo de Cocina">',
        showCancelButton: true,
        confirmButtonText: 'Crear',
        cancelButtonText: 'Cancelar',
        preConfirm: () => {
            const tipoCocina = Swal.getPopup().querySelector('#tipoCocinaInput').value;
            if (!tipoCocina) {
                Swal.showValidationMessage('Por favor, ingresa el nombre del tipo de cocina');
                return false;
            }
            return { tipo_cocina: tipoCocina };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Realizar la solicitud AJAX para crear el tipo de cocina
            $.ajax({
                url: './proc/crear_tipo_cocina.php',
                method: 'POST',
                dataType: 'json',
                data: result.value,
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








function mostrarFormulario() {
    // Realizar la solicitud AJAX para obtener los nombres de los gerentes y los tipos de cocina
    $.when(
        $.ajax({
            url: './proc/obtener_nombres_gerentes.php',
            method: 'GET',
            dataType: 'json'
        }),
        $.ajax({
            url: './proc/obtener_tipos_cocina.php',
            method: 'GET',
            dataType: 'json'
        })
    ).done(function(responseGerentes, responseCocinas) {
        if (responseGerentes[0].success && responseCocinas[0].success) {
            var gerentes = responseGerentes[0].data;
            var cocinas = responseCocinas[0].data;
            // Crear opciones para el select de gerentes
            var optionsGerentes = '';
            gerentes.forEach(function(gerente) {
                optionsGerentes += '<option value="' + gerente.id_usr + '">' + gerente.usr_nom + '</option>';
            });
            // Crear opciones para el select de cocinas
            var optionsCocinas = '';
            cocinas.forEach(function(cocina) {
                optionsCocinas += '<option value="' + cocina.id_cocina + '">' + cocina.cocina_nom + '</option>';
            });
            // Mostrar formulario con select en Swal
            Swal.fire({
                title: 'Añadir Restaurante',
                html:
                    '<input id="swal-input1" class="swal2-input" placeholder="Nombre">' +
                    '<input id="swal-input2" class="swal2-input" placeholder="Descripción">' +
                    '<select id="swal-select-gerente" class="swal2-select">' +
                    optionsGerentes +
                    '</select>' +
                    '<select id="swal-select-cocina" class="swal2-select">' +
                    optionsCocinas +
                    '</select>',
                showCancelButton: true,
                confirmButtonText: 'Añadir',
                cancelButtonText: 'Cancelar',
                preConfirm: () => {
                    const nombre = Swal.getPopup().querySelector('#swal-input1').value;
                    const descripcion = Swal.getPopup().querySelector('#swal-input2').value;
                    const idGerente = Swal.getPopup().querySelector('#swal-select-gerente').value; // Obtener la ID del gerente seleccionado
                    const idCocina = Swal.getPopup().querySelector('#swal-select-cocina').value; // Obtener la ID de la cocina seleccionada
                    if (!nombre || !idGerente) {
                        Swal.showValidationMessage('Nombre y Gerente son campos requeridos');
                    }
                    return { nombre: nombre, descripcion: descripcion, idGerente: idGerente, idCocina: idCocina }; // Enviar el nombre del restaurante
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const { nombre, descripcion, idGerente, idCocina } = result.value;

                    // Realizar la solicitud AJAX para crear el restaurante
                    $.ajax({
                        url: './proc/crear_restaurante.php',
                        method: 'POST',
                        dataType: 'json',
                        data: { nombre: nombre, descripcion: descripcion, idGerente: idGerente, idCocina: idCocina },
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
                    '<select id="swal-select-gerente" class="swal2-select">' +
                    '</select>' +
                    '<select id="swal-select-cocina" class="swal2-select">' +
                    '</select>',
                showCancelButton: true,
                confirmButtonText: 'Aplicar cambios',
                cancelButtonText: 'Cancelar',
                preConfirm: () => {
                    const nombre = Swal.getPopup().querySelector('#swal-input1').value;
                    const descripcion = Swal.getPopup().querySelector('#swal-input2').value;
                    const idGerente = Swal.getPopup().querySelector('#swal-select-gerente').value;
                    const idCocina = Swal.getPopup().querySelector('#swal-select-cocina').value;
                    if (!nombre || !idGerente) {
                        Swal.showValidationMessage('Nombre y Gerente son campos requeridos');
                    }
                    return { nombre: nombre, descripcion: descripcion, idGerente: idGerente, idCocina: idCocina };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const { nombre, descripcion, idGerente, idCocina } = result.value;

                    // Realizar la solicitud AJAX para actualizar el restaurante
                    $.ajax({
                        url: './proc/editar_restaurante.php',
                        method: 'POST',
                        dataType: 'json',
                        data: { id: id, nombre: nombre, descripcion: descripcion, idGerente: idGerente, idCocina: idCocina },
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
                        var selectGerente = document.getElementById('swal-select-gerente');
                        gerentes.data.forEach(function(gerente) {
                            var option = document.createElement('option');
                            option.value = gerente.id_usr;
                            option.text = gerente.usr_nom;
                            if (gerente.id_usr === response.id_usr_gerente) {
                                option.selected = true; // Seleccionar el gerente correspondiente
                            }
                            selectGerente.appendChild(option);
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

            // Llenar el select con los tipos de cocina y seleccionar el tipo de cocina correspondiente al restaurante
            $.ajax({
                url: './proc/obtener_tipos_cocina.php',
                method: 'GET',
                dataType: 'json',
                success: function(cocinas) {
                    if (cocinas.success) {
                        var selectCocina = document.getElementById('swal-select-cocina');
                        cocinas.data.forEach(function(cocina) {
                            var option = document.createElement('option');
                            option.value = cocina.id_cocina;
                            option.text = cocina.cocina_nom;
                            if (cocina.id_cocina === response.id_cocina) {
                                option.selected = true; // Seleccionar el tipo de cocina correspondiente al restaurante
                            }
                            selectCocina.appendChild(option);
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: cocinas.message
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un error al obtener los tipos de cocina.'
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



//FILTRO

$(document).ready(function() {
    // Escuchar el evento de cambio en los filtros
    $('#filtroNombre, #filtroCorreo, #filtroRol').on('input', function() {
        // Obtener los valores de los filtros
        var nombre = $('#filtroNombre').val().toLowerCase();
        var correo = $('#filtroCorreo').val().toLowerCase();
        var rol = $('#filtroRol').val().toLowerCase();

        // Filtrar las filas de la tabla
        $('#tablaUsuarios tbody tr').each(function() {
            var nombreUsuario = $(this).find('td:nth-child(2)').text().toLowerCase();
            var correoUsuario = $(this).find('td:nth-child(4)').text().toLowerCase();
            var rolUsuario = $(this).find('td:nth-child(6)').text().toLowerCase();

            // Mostrar u ocultar la fila según los valores de los filtros
            if (
                nombreUsuario.includes(nombre) &&
                correoUsuario.includes(correo) &&
                (rol === '' || rolUsuario === rol)
            ) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});












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
                const nombre = $('#nombreUsuario').val();
                const apellido = $('#apellidoUsuario').val();
                const email = $('#emailUsuario').val();
                const password = $('#passwordUsuario').val();

                // Expresiones regulares para validar los campos
                const nombreRegex = /^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/;
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                // Validar nombre y apellido
                if (!nombreRegex.test(nombre) || !nombreRegex.test(apellido)) {
                    Swal.showValidationMessage('Nombre y apellido solo pueden contener letras.');
                    return false;
                }

                // Validar email
                if (!emailRegex.test(email)) {
                    Swal.showValidationMessage('Correo electrónico no válido.');
                    return false;
                }

                // Validar contraseña
                if (password.length < 5) {
                    Swal.showValidationMessage('La contraseña debe tener al menos 5 caracteres.');
                    return false;
                }

                return {
                    nombre: nombre,
                    apellido: apellido,
                    email: email,
                    password: password,
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
                    mostrarFormularioEditar(usuario);
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
                            eliminarUsuario(usuario.id);
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

// Función para mostrar el formulario de edición de usuario en un Sweet Alert
function mostrarFormularioEditar(usuario) {
    const roles = ['Admin', 'User', 'Gerente'];
    let selectOptions = '';
    roles.forEach(function(rol) {
        selectOptions += `<option value="${rol}" ${usuario.rol === rol ? 'selected' : ''}>${rol}</option>`;
    });

    Swal.fire({
        title: 'Editar Usuario',
        html:
            `<form id="formEditarUsuario">
                <input type="hidden" id="idUsuario" value="${usuario.id}">
                <input id="nombreUsuario" class="swal2-input" placeholder="Nombre" value="${usuario.nombre}">
                <input id="apellidoUsuario" class="swal2-input" placeholder="Apellido" value="${usuario.apellido}">
                <input id="emailUsuario" class="swal2-input" placeholder="Correo electrónico" value="${usuario.email}">
                <input type="password" id="passwordUsuario" class="swal2-input" placeholder="Contraseña" value="${usuario.password}">
                <select id="rolUsuario" class="swal2-select">
                    ${selectOptions}
                </select>
            </form>`,
        showCancelButton: true,
        confirmButtonText: 'Guardar',
        cancelButtonText: 'Cancelar',
        preConfirm: () => {
            return {
                id: $('#idUsuario').val(),
                nombre: $('#nombreUsuario').val(),
                apellido: $('#apellidoUsuario').val(),
                email: $('#emailUsuario').val(),
                password: $('#passwordUsuario').val(),
                rol: $('#rolUsuario').val()
            };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Aquí puedes enviar la solicitud para guardar los cambios del usuario desde tu backend
            console.log('Guardar cambios del usuario:', result.value);
            editarUsuario(result.value);
        }
    });

    // Evitar que el formulario se envíe al presionar Enter
    $('#formEditarUsuario').submit(function(event) {
        event.preventDefault();
    });
}

// Función para editar un usuario
function editarUsuario(datosUsuario) {
    $.ajax({
        url: './proc/editar_usuario.php',
        method: 'POST',
        dataType: 'json',
        data: datosUsuario,
        success: function(response) {
            console.log('Respuesta del servidor:', response);
            if (response.success) {
                Swal.fire('Usuario actualizado correctamente', response.message, 'success');
                // Aquí puedes recargar la lista de usuarios o actualizarla con AJAX
                cargarUsuarios();
            } else {
                Swal.fire('Error', response.message, 'error');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud AJAX:', error);
            Swal.fire('Error', 'Hubo un error al procesar la solicitud.', 'error');
        }
    });
}

// Función para eliminar un usuario
function eliminarUsuario(idUsuario) {
    $.ajax({
        url: './proc/verificar_usuario.php',
        method: 'POST',
        dataType: 'json',
        data: { id: idUsuario },
        success: function(response) {
            console.log('Respuesta del servidor:', response);
            if (response.success) {
                // Usuario verificado correctamente, ahora verificamos si es gerente y tiene restaurantes asociados
                if (response.isGerente && response.hasRestaurantes) {
                    // El usuario es gerente y tiene restaurantes asociados, mostrar el Sweet Alert de confirmación
                    mostrarSweetAlertConfirmacion(idUsuario);
                } else {
                    // El usuario no es gerente o no tiene restaurantes asociados, eliminar directamente
                    eliminarDirectamenteUsuario(idUsuario);
                }
            } else {
                Swal.fire('Error', response.message, 'error');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud AJAX:', error);
            Swal.fire('Error', 'Hubo un error al procesar la solicitud.', 'error');
        }
    });
}

// Función para mostrar Sweet Alert de confirmación si el usuario es gerente y tiene restaurantes asociados
function mostrarSweetAlertConfirmacion(idUsuario) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Este gerente tiene restaurantes asociados. ¿Deseas eliminarlo y también eliminar los restaurantes asociados?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Si el usuario confirma, procedemos a eliminarlo y sus restaurantes asociados
            eliminarDirectamenteUsuario(idUsuario);
        }
    });
}

// Función para eliminar directamente al usuario y sus restaurantes asociados
function eliminarDirectamenteUsuario(idUsuario) {
    $.ajax({
        url: './proc/eliminar_usuario.php',
        method: 'POST',
        dataType: 'json',
        data: { id: idUsuario },
        success: function(response) {
            console.log('Respuesta del servidor:', response);
            if (response.success) {
                Swal.fire('Usuario eliminado correctamente', response.message, 'success');
                // Aquí puedes recargar la lista de usuarios o actualizarla con AJAX
                cargarUsuarios();
            } else {
                Swal.fire('Error', response.message, 'error');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud AJAX:', error);
            Swal.fire('Error', 'Hubo un error al procesar la solicitud.', 'error');
        }
    });
}
cargarUsuarios();
});



























// ----------------------------------------------------------------------------------------PLATOS -----------------------------------------------------------









//FILTRO

$(document).ready(function() {
    // Cargar los platos al cargar la página
    cargarPlatos();

    // Manejar el envío del formulario de filtro mediante AJAX
    $('#filtroForm').submit(function(event) {
        // Evitar que el formulario se envíe de forma tradicional
        event.preventDefault();
        // Obtener los datos del formulario
        var formData = $(this).serialize();
        // Realizar la solicitud AJAX para filtrar los platos
        filtrarPlatos(formData);
    });

    // Función para cargar todos los platos
    function cargarPlatos() {
        $.ajax({
            type: 'GET',
            url: './proc/procesar_platos.php', // Ruta al archivo PHP que manejará la solicitud
            success: function(response) {
                // Actualizar la tabla de platos con los datos recibidos
                $('#tablaPlatos').html(response);
            },
            error: function(xhr, status, error) {
                // Manejar errores de la solicitud
                console.error(error);
            }
        });
    }

    // Función para filtrar los platos
    function filtrarPlatos(formData) {
        $.ajax({
            type: 'GET',
            url: './proc/procesar_platos.php', // Ruta al archivo PHP que manejará la solicitud
            data: formData,
            success: function(response) {
                // Actualizar la tabla de platos con los datos filtrados
                $('#tablaPlatos').html(response);
            },
            error: function(xhr, status, error) {
                // Manejar errores de la solicitud
                console.error(error);
            }
        });
    }

    // Cargar los restaurantes en el filtro de restaurante
    function cargarRestaurantes() {
        $.ajax({
            type: 'GET',
            url: './proc/procesar_restaurantes.php', // Ruta al archivo PHP que manejará la solicitud
            success: function(response) {
                // Actualizar el select de restaurante con los datos recibidos
                $('#filtroRestaurante').html(response);
            },
            error: function(xhr, status, error) {
                // Manejar errores de la solicitud
                console.error(error);
            }
        });
    }

    // Llamar a la función para cargar los restaurantes al cargar la página
    cargarRestaurantes();
});













$(document).ready(function() {
    // Función para cargar los platos
    function cargarPlatos(filtros = {}) {
        $.ajax({
            url: './proc/obtener_platos.php',
            method: 'GET',
            data: filtros, // Pasar los filtros como parámetro
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
                // Mostrar mensaje de error descriptivo
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un error al cargar la lista de platos: ' + error
                });
            }
        });
    }

    // Llamar a cargarPlatos() al cargar la página para mostrar todos los platos por defecto
    cargarPlatos();

    // Evento de cambio en los filtros para volver a cargar los platos según los nuevos filtros
    $('#filtroNombrePlato, #filtroPrecioMin, #filtroPrecioMax, #filtroRestaurante').on('change', function() {
        const filtros = {
            nombrePlato: $('#filtroNombrePlato').val(),
            precioMin: $('#filtroPrecioMin').val(),
            precioMax: $('#filtroPrecioMax').val(),
            idRestaurante: $('#filtroRestaurante').val()
        };
        cargarPlatos(filtros);
    });

    // Cargar la lista de restaurantes al cargar la página
    $.ajax({
        url: './proc/obtener_restaurante_platos2.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            const filtroRestaurante = $('#filtroRestaurante');
            filtroRestaurante.empty();
            filtroRestaurante.append($('<option>').val('').text('Todos')); // Opción por defecto
            data.forEach(function(restaurante) {
                filtroRestaurante.append($('<option>').val(restaurante.id_restaurante).text(restaurante.rest_nom));
            });
        },
        error: function(xhr, status, error) {
            // Mostrar mensaje de error descriptivo
            console.error(error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un error al cargar la lista de restaurantes: ' + error
            });
        }
    });















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
                    
                    // Validar que el precio no contenga letras utilizando una expresión regular
                    if (!nombre || !precio || !id_restaurante || !/^\d+(\.\d+)?$/.test(precio)) {
                        Swal.showValidationMessage('Nombre, Precio y Restaurante son campos requeridos. El precio debe ser un número.');
                        return false; // Devolver falso para evitar que se cierre el cuadro de diálogo
                    }
                    return { id_plato: plato.id_plato, nombre: nombre, precio: precio, id_restaurante: id_restaurante };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const { id_plato, nombre, precio, id_restaurante } = result.value;
                    // Enviar los datos actualizados al servidor
                    actualizarPlato(id_plato, nombre, precio, id_restaurante);
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
function actualizarPlato(idPlato, nombre, precio, idRestaurante) {
    $.ajax({
        url: './proc/actualizar_plato.php',
        method: 'POST',
        dataType: 'json',
        data: { id_plato: idPlato, nombre: nombre, precio: precio, id_restaurante: idRestaurante }, // Agregar id_restaurante
        success: function(response) {
            if (response.success) {
                Swal.fire('Plato actualizado correctamente', response.message, 'success');
                                // Recargar la lista de platos después de la actualización
                                cargarPlatos();
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
    // Mostrar SweetAlert de confirmación
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará el plato. Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar plato'
    }).then((result) => {
        // Si se confirma la eliminación
        if (result.isConfirmed) {
            // Realizar una petición AJAX para eliminar el plato
            $.ajax({
                url: './proc/eliminar_plato.php', // Archivo PHP para eliminar el plato
                method: 'POST',
                dataType: 'json',
                data: { id_plato: id },
                success: function(response) {
                    if (response.success) {
                        // Mostrar mensaje de éxito
                        Swal.fire('Plato eliminado', response.message, 'success');
                        // Recargar la página o actualizar la lista de platos
                        cargarPlatos();
                    } else {
                        // Mostrar mensaje de error
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    // Mostrar mensaje de error en caso de fallo en la solicitud AJAX
                    console.error('Error en la solicitud AJAX:', error);
                    Swal.fire('Error', 'Hubo un error al procesar la solicitud.', 'error');
                }
            });
        }
    });
}


// Cargar los platos al cargar la página
cargarPlatos();



$('#btnAgregarPlato').click(function() {
    // Realizar la solicitud AJAX para obtener todos los restaurantes
    $.ajax({
        url: './proc/obtener_restaurantes_platos.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // Construir opciones del select con los restaurantes obtenidos
                var optionsRestaurantes = '';
                response.data.forEach(function(restaurante) {
                    optionsRestaurantes += '<option value="' + restaurante.id_restaurante + '">' + restaurante.rest_nom + '</option>';
                });

                // Mostrar el formulario con el select de restaurantes en Swal
                Swal.fire({
                    title: 'Agregar Plato',
                    html:
                        '<input id="swal-input1" class="swal2-input" placeholder="Nombre">' +
                        '<input id="swal-input2" class="swal2-input" placeholder="Precio">' +
                        '<select id="swal-select-restaurantes" class="swal2-select">' +
                        optionsRestaurantes +
                        '</select>',
                    showCancelButton: true,
                    confirmButtonText: 'Guardar',
                    cancelButtonText: 'Cancelar',
                    preConfirm: () => {
                        const nombre = Swal.getPopup().querySelector('#swal-input1').value;
                        const precio = Swal.getPopup().querySelector('#swal-input2').value;
                        const idRestaurante = Swal.getPopup().querySelector('#swal-select-restaurantes').value;

                        // Validar que el campo "Nombre" no esté vacío y contenga solo letras
                        if (!nombre || !/^[a-zA-Z]+$/.test(nombre)) {
                            Swal.showValidationMessage('El nombre del plato no puede estar vacío y debe contener solo letras');
                            return false;
                        }

                        // Verificar si el precio es un número
                        if (!precio || isNaN(parseFloat(precio))) {
                            Swal.showValidationMessage('El precio solo puede tener números');
                            return false;
                        }

                        return { nombre: nombre, precio: precio, idRestaurante: idRestaurante };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const { nombre, precio, idRestaurante } = result.value;
                        $.ajax({
                            url: './proc/crear_plato.php',
                            method: 'POST',
                            dataType: 'json',
                            data: { nombre: nombre, precio: precio, idRestaurante: idRestaurante },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire('Plato creado correctamente', response.message, 'success');
                                    cargarPlatos();
                                } else {
                                    Swal.fire('Error', response.message, 'error');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error en la solicitud AJAX:', error);
                                Swal.fire('Error', 'Hubo un error al procesar la solicitud.', 'error');
                            }
                        });
                    }
                });
            } else {
                // Manejar el caso en que no se puedan obtener los restaurantes
                Swal.fire('success', response.message, 'success');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud AJAX:', error);
            Swal.fire('Error', 'Hubo un error al obtener los restaurantes.', 'error');
        }
    });
});

// Cargar los platos al cargar la página
cargarPlatos();
});
