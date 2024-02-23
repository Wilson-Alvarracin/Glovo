// Variable para almacenar la referencia al botón de valoración
var btnValoracion = document.getElementById('btn_valoracion');
btnValoracion.onclick = insertarValoracion;

// Función para manejar el evento onclick y mostrar un SweetAlert en lugar del formulario
document.getElementById('mostrarFormulario').onclick = function() {
    var id_user = document.getElementById('id_usr');
    // Mostrar SweetAlert con los campos de entrada para la valoración y el comentario
    Swal.fire({
        title: 'Insertar valoración',
        html: '<form>' +
            '<div id="rateYo"></div>' +
            '<div class="counter"></div>' +
            '<label for="comentario">Comentario:</label>' +
            '<textarea id="swal-input2" class="swal2-input" placeholder="Comentario"></textarea>' +
            '<input type="hidden" id="id_usr" value="' + id_user + '">' +
            '</form>',
        focusConfirm: false,
        preConfirm: () => {
            const valoracion = document.getElementById('rateYo').innerText; // Ajusta esto según la manera en que obtienes la valoración
            const comentario = Swal.getPopup().querySelector('#swal-input2').value;
            // Llama a la función insertarValoracion con los datos proporcionados
            insertarValoracion(valoracion, comentario);
        }
    });
};

// Función para insertar la valoración
function insertarValoracion(valoracion, comentario) {
    var restauranteID = document.getElementById('id_restaurante').value;
    var id_usr = document.getElementById('id_usr').value;

    // Realizar la solicitud AJAX para insertar la valoración
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'insertar_valoracion.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            // Parsear la respuesta JSON
            var response = JSON.parse(xhr.responseText);

            // Manejar la respuesta
            if (response.success) {
                // Mostrar SweetAlert de éxito
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: response.message,
                });

                // Limpiar los campos del formulario
                //document.getElementById('valoracion').value = ''; // Esto depende de cómo obtienes la valoración
                document.getElementById('comentario').value = '';
            } else {
                // Mostrar SweetAlert de error
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message,
                });

                // Limpiar los campos del formulario
                //document.getElementById('valoracion').value = ''; // Esto depende de cómo obtienes la valoración
                document.getElementById('comentario').value = '';
            }
        } else {
            console.error('Error al insertar la valoración. Estado: ' + xhr.status);
        }
    };

    // Enviar los datos del formulario al servidor
    xhr.send('valoracion=' + encodeURIComponent(valoracion) + '&comentario=' + encodeURIComponent(comentario) + '&restaurante_id=' + encodeURIComponent(restauranteID) + '&id_usr=' + encodeURIComponent(id_usr));
}