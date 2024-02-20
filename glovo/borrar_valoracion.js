
function borrarValoracion(valoracionId) {
    // Hace una petición AJAX para borrar la valoración
    var xhrDelete = new XMLHttpRequest();
    xhrDelete.onreadystatechange = function () {
        if (xhrDelete.readyState == 4) {
            if (xhrDelete.status == 200) {
                // Parsear la respuesta JSON
                var responseDelete = JSON.parse(xhrDelete.responseText);

                if (responseDelete.success) {
                    // Éxito en el borrado, muestra un SweetAlert de éxito y actualiza los comentarios
                    Swal.fire({
                        icon: 'success',
                        title: 'Borrado exitoso',
                        text: 'La valoración se ha borrado correctamente.',
                    }).then(function () {
                        updateComments();
                    });
                } else {
                    // Error en el borrado, muestra un SweetAlert de error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al borrar la valoración: ' + responseDelete.error,
                    });
                }
            } else {
                // Mostrar SweetAlert en caso de fallo en la solicitud AJAX
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al realizar la solicitud de borrado: ' + xhrDelete.statusText,
                });
            }
        }
    };

    xhrDelete.open('GET', 'borrar_valoracion.php?valoracion_id=' + valoracionId, true);
    xhrDelete.send();
}

// document.addEventListener("DOMContentLoaded", function () {
//     // Agrega un evento de clic a los botones de borrar
//     var botonesBorrar = document.getElementsByClassName('btn-borrar');
//     for (var i = 0; i < botonesBorrar.length; i++) {
//         botonesBorrar[i].addEventListener('click', function () {
//             // Obtiene el ID de la valoración desde el atributo data-valoracion-id
//             var valoracionId = this.getAttribute('data-valoracion-id');

//             // Llama a la función borrarValoracion pasando el ID de la valoración
//             borrarValoracion(valoracionId);
//         });
//     }
// });
