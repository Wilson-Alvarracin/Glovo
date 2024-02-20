document.addEventListener("DOMContentLoaded", function () {
    function updateComments() {
        // Obtener el ID del restaurante desde el input oculto
        var restaurantId = document.getElementById('id_restaurante').value;

        // Hacer una petición AJAX para obtener comentarios del servidor
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    // Parsear la respuesta JSON
                    var response = JSON.parse(xhr.responseText);

                    // Mostrar la tabla en el div con id 'comentarios_all'
                    var commentsDiv = document.getElementById('comentarios_all');
                    commentsDiv.innerHTML = response.contenido || '';

                    // Si hay un mensaje, mostrarlo
                    if (response.message) {
                        commentsDiv.innerHTML += '<p>' + response.message + '</p>';
                    }
                } else {
                    // Mostrar el error en el div 'comentarios_all'
                    var commentsDiv = document.getElementById('comentarios_all');
                    commentsDiv.innerHTML = '<p>Error al obtener comentarios: ' + xhr.statusText + '</p>';
                }
            }
        };

        xhr.open('GET', 'get_comments.php?restaurant_id=' + restaurantId, true);
        xhr.send();
    }

    // Llamar a la función inicialmente
    updateComments();

    // Actualizar cada segundo
    setInterval(updateComments, 1000);
});
