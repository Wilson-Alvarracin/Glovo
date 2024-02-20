<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platos</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #343a40;
        }

        #platos {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            color: #e44d26;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        a {
            text-decoration: none;
            color: #e44d26;
            display: inline-block;
            margin-top: 20px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>
    <?php
    $restaurant_id = isset($_GET['restaurant_id']) ? $_GET['restaurant_id'] : 0;
    echo "<input type='hidden' id='id_restaurante' value='" . $restaurant_id . "'>";
    $id_user = 9;

    ?>
    <div id="platos"></div>

    <!-- Formulario para insertar valoraciones -->
    <form id="valoracionForm">
        <label for="valoracion">Valoración:</label>
        <input type="number" id="valoracion" name="valoracion" min="1" max="5" required>

        <label for="comentario">Comentario:</label>
        <textarea id="comentario" name="comentario" required></textarea>

        <!-- Añade un campo oculto para almacenar el id_usr -->
        <?php
        echo "<input type='hidden' id='id_usr' name='id_usr' value='".$id_user."'>" 
        ?>

        <button type="button" id="btn_valoracion">Enviar Valoración</button>
    </form>

    <br>
    <br>

    <h2>Comentarios</h2>
    <div id="comentarios_all"></div>


    <a href="index.php">Volver a la página anterior</a>
</body>

<script src="./ajax.js"></script>
<script src="./valoracion.js"></script>
<script src="./mostrar_comentarios.js"></script>

</html>