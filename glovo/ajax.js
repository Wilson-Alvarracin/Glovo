// Function to fetch and display restaurant information
function fetchRestaurantInfo() {
    // Get the div with id 'platos'
    var platosDiv = document.getElementById('platos');
    var tituloDiv = document.getElementById('titulo');
    var iconoDiv = document.getElementById('icono');
    var backgroundDiv = document.getElementById('background');
    var inputID = document.getElementById('id_restaurante').value;

    // Make an AJAX request to your PHP script
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'mostrar_platos.php?restaurant_id=' + inputID, true);

    // Set up the callback function to handle the response
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            // Parse the JSON response
            var response = JSON.parse(xhr.responseText);

            // Display the restaurant name
            tituloDiv.innerHTML = "<h1><b>" + response.restaurant_name + "</b></h1>";

            platosDiv.innerHTML += "<p>" + response.restaurant_description + "</p>";

            iconoDiv.innerHTML = "<img src='../img/logo/" + response.restaurant_logo + ".jpg'>";

            backgroundDiv.innerHTML = "<img class='background-image blurred-img' src='../img/background/" + response.restaurant_header + ".jpg'>";

            // Display the products
            if (response.products.length > 0) {
                platosDiv.innerHTML += "<ul>";
                response.products.forEach(function(product) {
                    platosDiv.innerHTML += "<li>" + product.plato_descripcion + " - Precio: " + product.plato_precio + "€</li>";
                    platosDiv.innerHTML += "<img src='../img/product/" + product.plato_imagen + ".jpg'>";
                });
                platosDiv.innerHTML += "</ul>";
            } else {
                platosDiv.innerHTML += "<p>No products available for this restaurant.</p>";
            }
        } else {
            console.error('Request failed with status ' + xhr.status);
        }
    };

    // Send the request
    xhr.send();
}

// Call the function initially
fetchRestaurantInfo();

// Set up setInterval to fetch and display information every 1 second
// setInterval(fetchRestaurantInfo, 1000);