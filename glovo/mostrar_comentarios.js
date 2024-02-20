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
                    var comments = JSON.parse(xhr.responseText);

                    // Mostrar los comentarios en el div con id 'comentarios_all'
                    var commentsDiv = document.getElementById('comentarios_all');
                    commentsDiv.innerHTML = ''; // Limpiar contenido anterior

                    // Verificar si hay comentarios
                    if (Array.isArray(comments) && comments.length > 0) {
                        comments.forEach(function (comment) {
                            var commentItem = document.createElement('div');
                            commentItem.innerHTML = '<strong>' + comment.user + ':</strong> ' + comment.comment + ' - estrellas = ' + comment.valoracion;
                            commentsDiv.appendChild(commentItem);
                        });
                    } else {
                        // No hay comentarios
                        commentsDiv.innerHTML = '<p>No hay comentarios para este restaurante.</p>';
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