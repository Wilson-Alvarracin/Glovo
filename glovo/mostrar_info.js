// Agregar un event listener al botón que llama a la función fetchRestaurantInfo
btnMostrarInformacion.addEventListener('click', function() {
    var inputID = document.getElementById('id_restaurante').value;
    // Make an AJAX request to your PHP script
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'mostrar_platos.php?restaurant_id=' + inputID, true);

    // Set up the callback function to handle the response
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            // Parse the JSON response
            var response = JSON.parse(xhr.responseText);

            // Show the restaurant description in a SweetAlert
            Swal.fire({
                title: '<b style="color: #00a082;">Descripción del Restaurante</b>',
                html: '<p>' + response.restaurant_description + '</p>',
                icon: 'info'
            });
        } else {
            console.error('Request failed with status ' + xhr.status);
        }
    };

    // Send the request
    xhr.send();
});