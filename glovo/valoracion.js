
var btnValoracion = document.getElementById('btn_valoracion');
btnValoracion.onclick = insertarValoracion;

function insertarValoracion() {
    var valoracion = document.getElementById('valoracion').value;
    var comentario = document.getElementById('comentario').value;
    var restauranteID = document.getElementById('id_restaurante').value;
    var id_usr = document.getElementById('id_usr').value;

    // Realizar la solicitud AJAX para insertar la valoración
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'insertar_valoracion.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
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

                document.getElementById('valoracion').value = '';
                document.getElementById('comentario').value = '';
            } else {
                // Mostrar SweetAlert de error
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message,
                });

                document.getElementById('valoracion').value = '';
                document.getElementById('comentario').value = '';
            }
        } else {
            console.error('Error al insertar la valoración. Estado: ' + xhr.status);
        }
    };

    xhr.send('valoracion=' + encodeURIComponent(valoracion) + '&comentario=' + encodeURIComponent(comentario) + '&restaurante_id=' + encodeURIComponent(restauranteID) + '&id_usr=' + encodeURIComponent(id_usr));
}
