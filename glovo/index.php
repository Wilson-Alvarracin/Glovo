<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Restaurants</title>
</head>

<body>
    <h1>All Restaurants</h1>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "db_glovo";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch all restaurants
    $restaurants_query = "SELECT id_restaurante, rest_nom, rest_desc FROM tbl_restaurante";
    $restaurants_result = $conn->query($restaurants_query);

    if ($restaurants_result->num_rows > 0) {
        while ($restaurant = $restaurants_result->fetch_assoc()) {
            echo "<p><a href='platos.php?restaurant_id={$restaurant['id_restaurante']}'>{$restaurant['rest_nom']}</a> - {$restaurant['rest_desc']}</p>";
        }
    } else {
        echo "<p>No restaurants available.</p>";
    }

    $conn->close();
    ?>
</body>

</html>
