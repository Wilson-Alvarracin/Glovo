<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platos</title>
</head>

<body>
    <?php
    $restaurant_id = isset($_GET['restaurant_id']) ? $_GET['restaurant_id'] : 0;
    echo "<input type='hidden' id='id_restaurante' value='".$restaurant_id."'>"
    
    ?>
<div id="platos"></div>
</body>

<script src="./ajax.js"></script>

</html>
