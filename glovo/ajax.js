// Function to fetch and display restaurant information
function fetchRestaurantInfo() {
    // Get the div with id 'platos'
    var tituloDiv = document.getElementById('titulo');
    var iconoDiv = document.getElementById('icono');
    var backgroundDiv = document.getElementById('background');
    var inputID = document.getElementById('id_restaurante').value;
    // Product values
    var cartaProducto = document.getElementById('producto');

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

            iconoDiv.innerHTML = "<img src='../img/logo/" + response.restaurant_logo + ".jpg'>";

            backgroundDiv.innerHTML = "<img class='background-image blurred-img' src='../img/background/" + response.restaurant_header + ".jpg'>";

            // Display the products
            if (response.products.length > 0) {

                response.products.forEach(function(product) {
                    cartaProducto.innerHTML += '<div class="column-3">\
                    <div class="card mb-3" style="max-width: 540px; margin: 10px;">\
                        <div class="row g-0">\
                            <div class="col-md-4">\
                            <img src="../img/product/' + product.plato_imagen + '.jpg" class="img-fluid rounded-start" alt="">\
                            </div>\
                            <div class="col-md-8">\
                                <div class="card-body">\
                                    <h5 class="card-title">' + product.plato_nombre + '</h5>\
                                    <p class="card-text">' + product.plato_descripcion + '</p>\
                                    <p class="card-text"><small class="text-muted">Precio: ' + product.plato_precio + '€</small></p>\
                                </div>\
                            </div>\
                        </div>\
                    </div>\
                    </div>';
                });

            } else {
                cartaProducto.innerHTML += "<p>No products available for this restaurant.</p>";
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