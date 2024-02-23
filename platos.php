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

        #valoracionForm {
            display: none;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
</head>

<body>
    <?php
    $restaurant_id = isset($_GET['restaurant_id']) ? $_GET['restaurant_id'] : 0;
    echo "<input type='hidden' id='id_restaurante' value='" . $restaurant_id . "'>";
    $id_user = 11;
    $_SESSION['id_user'] = $id_user;

    ?>
    <div id="platos"></div>

    <a href="#" id="mostrarFormulario">Mostrar Formulario de Valoración</a>
    <!-- Formulario para insertar valoraciones -->
    <form id="valoracionForm">
        <label for="valoracion">Valoración:</label>
        <div id="rateYo"></div>
        <div class="counter"></div>
        <input type="number" id="valoracion" name="valoracion" min="1" max="5">
        <!-- <span id="valoracion"></span> -->

        <label for="comentario">Comentario:</label>
        <textarea id="comentario" name="comentario"></textarea>

        <!-- Añade un campo oculto para almacenar el id_usr -->
        <?php
        echo "<input type='hidden' id='id_usr' name='id_usr' value='" . $id_user . "'>"
        ?>

        <button type="button" id="btn_valoracion">Enviar Valoración</button>
    </form>

    <br>
    <br>

    <h2>Comentarios</h2>
    <div id="comentarios_all"></div>

    <h2>Media Estrellas</h2>
    <p id="media_valoracion"></p>


    <a href="index.php">Volver a la página anterior</a>
</body>
<script>
    $(function() {

        $("#rateYo").rateYo({

            rating: 0,
            halfStar: true,
            spacing: "5px",
            multiColor: {
                "startColor": "#FF0000", //RED
                "endColor": "#00FF00" //GREEN
            },
            onChange: function(rating, rateYoInstance) {
                $("#valoracion").val(rating);
            }

        });

    });
</script>
<script src="./ajax.js"></script>
<script src="./valoracion.js"></script>
<script src="./mostrar_comentarios.js"></script>
<script src="./borrar_valoracion.js"></script>
<script src="./calcular_avg.js"></script>

</html>