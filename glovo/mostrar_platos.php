<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_glovo";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$restaurant_id = isset($_GET['restaurant_id']) ? $_GET['restaurant_id'] : 0;

// Fetch restaurant name for display
$restaurant_query = "SELECT rest_nom, rest_desc, rest_header, rest_logo FROM tbl_restaurante WHERE id_restaurante = $restaurant_id";
$restaurant_result = $conn->query($restaurant_query);

if ($restaurant_result->num_rows > 0) {
    $row = $restaurant_result->fetch_assoc();
    $restaurant_name = $row['rest_nom'];
    $restaurant_description = $row['rest_desc'];
    $restaurant_logo = $row['rest_logo'];
    $restaurant_header = $row['rest_header'];
} else {
    $restaurant_name = "Unknown Restaurant";
}

// Fetch products for the specific restaurant
$product_query = "SELECT * FROM tbl_platos WHERE id_restaurante = $restaurant_id";
$product_result = $conn->query($product_query);

// Output the restaurant name and products as JSON
$output = [
    'restaurant_name' => $restaurant_name,
    'restaurant_description' => $restaurant_description,
    'restaurant_header' => $restaurant_header,
    'restaurant_logo' => $restaurant_logo,
    'products' => []
];

if ($product_result) { // Check if the query was successful
    if ($product_result->num_rows > 0) {
        while ($product = $product_result->fetch_assoc()) {
            $output['products'][] = [
                'plato_nombre' => $product['plato_nombre'],
                'plato_descripcion' => $product['plato_descripcion'],
                'plato_precio' => $product['plato_precio'],
                'plato_imagen' => $product['plato_imagen'],
            ];
        }
    } else {
        $output['error'] = "No products found for this restaurant.";
    }
} else {
    $output['error'] = "Query failed: " . $conn->error;
}

echo json_encode($output, JSON_PRETTY_PRINT); // Use JSON_PRETTY_PRINT for a more readable output

$conn->close();
?>