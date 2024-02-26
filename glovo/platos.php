<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platos</title>
    <style>
        @font-face {
            font-family: 'Gotham';
            src: url('../fonts/Gotham-Bold.ttf') format('truetype'), url('../fonts/Gotham-Medium.ttf') format('truetype'), url('../fonts/Gotham-Light.ttf') format('truetype');
        }

        body {
            font-family: 'Gotham', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .background-row {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 30vh;
            /* Utilizamos viewport height */
            min-height: 150px;
            /* Altura mínima en píxeles */
            z-index: -1;
            overflow: hidden;
            /* Para asegurar que el contenido interno no se desborde */
            /* Agregamos position: relative para que los hijos position: absolute se posicionen con respecto a este elemento */
            position: relative;
        }

        .background-image {
            /* Establecemos la posición absoluta para que el elemento se posicione correctamente dentro del contenedor */
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .glovo_title {
            position: absolute;
            top: 0;
            left: 0;
            width: 7%;
            margin-left: 60px;
            margin-top: 30px;
            z-index: 2;
            color: white;

        }

        .turn-back {
            position: absolute;
            z-index: 2;
            color: white;
        text-decoration: none;
        }

        .blurred-img {
            filter: blur(10px);
        }

        .icon {
            width: 100px;
            height: 100px;
            overflow: hidden;
            border: 2px solid #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
            position: relative;
            /* Agregamos posición relativa al contenedor */
            margin-top: -40px;
            margin-left: 60px;
        }

        .icon img {
            width: 100%;
            height: auto;
            /* La altura se ajusta automáticamente para mantener la relación de aspecto */
            object-fit: cover;
            top: -50px;
            left: -50px;
        }

        .icon-comment {
            width: 50px;
            height: 50px; /* Ajusta la altura según sea necesario */
            overflow: hidden;
            position: relative;
            background-color: transparent; /* Sin fondo */
            border-radius: 50%; /* Hace que el borde sea redondo para que coincida con la forma circular de la imagen */
            float: left;
        }

        .icon-comment img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        .name-comment {
            margin-left: 60px;
        }


        .row1 {
            flex: 1;
            background-color: #f0f0f0;
        }

        .row2 {
            height: 100px;
        }

        .pagina {
            max-width: 1600px;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 3px 7px 7px rgba(0, 0, 0, 0.5);
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            /* Los elementos se apilan verticalmente */
            margin-right: auto;
            margin-left: auto;
            margin-bottom: 20px;
        }

        .contenido-pagina {
            margin-left: 60px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        a {
            display: inline-block;
            margin-top: 20px;
        }

        a:hover {
            text-decoration: underline;
        }

        #valoracionForm {
            display: none;
        }

        .icon-svg {
            width: 24px;
            fill: gold;
            transition: fill 0.3s, transform 0.3s;
            cursor: pointer;
        }

        .icon-svg:hover,
        .enlace-valoracion:hover .icon-svg {
            fill: red;
            /* Nuevo color del icono al pasar el mouse */
            transform: scale(1.2);
            /* Aumenta el tamaño del icono al 130% */
        }

        .enlace-valoracion:hover {
            opacity: 1;
            /* Ajusta la transparencia al pasar el mouse */
        }

        .enlace-valoracion {
            text-decoration: none;
            color: #666;
            background-color: transparent;
            padding: 5px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .enlace-valoracion:hover {
            background-color: #f0f0f0;
            text-decoration: none;
            /* Cambia el color de fondo al pasar el mouse */
        }

        .atributo-pagina {
            width: 24px;
            margin-left: 150px;
            fill: #666;

        }

        .slt:after {
            content: "";
            display: table;
            clear: both;
        }

        .column-3 {
            width: 33%;
            float: left;
        }

        .card:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transform: translateY(-5px);
            cursor: pointer;
        }

        .card:hover .card-title {
            color: #e5213f;
        }

        /* Establece un fondo y un marco para un elemento con la clase "elemento-estilo" */
        .elemento-estilo {
            background-color: #f0f0f0; /* Color de fondo */
            border: 2px solid #ccc; /* Borde sólido de 2px con color gris claro */
            padding: 10px; /* Espacio interno alrededor del contenido */
            display: flex;
            padding-left: 35%;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
    <!-- Bootstrap CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <!--  Iconos -->
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</head>

<body>
    <div class='background-row'>
        <div id='background'></div>
        <img class='glovo_title' src="../img/Glovo_logo_blanco.png" alt="Glovo_logo_blanco">
    </div>
    <?php
    $restaurant_id = isset($_GET['restaurant_id']) ? $_GET['restaurant_id'] : 0;
    echo "<input type='hidden' id='id_restaurante' value='" . $restaurant_id . "'>";
    $id_user = 18;
    $_SESSION['id_user'] = $id_user;

    ?>
    <div class='pagina' style='margin-top: -20px;'>
    <div id='volver'></div>  <!-- Enlace para volver atrás -->
        <div class='icon row1' id='icono'>
            <img src="../img/logo/kfc_icon.jpg" alt="">
        </div>
        <div class='contenido-pagina' id='titulo'></div> <!-- Título -->

        <div class="label contenido-pagina">
            <!-- Enlace de Valoración -->
            <a href="#" id='mostrarFormulario' class='enlace-valoracion'>
                <svg class="icon-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2l2.297 7.068H22l-6.34 4.6 2.4 7.365-6.364-4.6-6.364 4.6 2.4-7.365L2 9.068h7.703z" />
                </svg><!-- Icono -->
                <b style="vertical-align: middle;" id="media_valoracion"></b> <!-- Texto -->
            </a>
            <!-- Icono del tiempo -->
            <svg class='atributo-pagina' style='fill: #5460c8' xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path d="m20.145 8.27 1.563-1.563-1.414-1.414L18.586 7c-1.05-.63-2.274-1-3.586-1-3.859 0-7 3.14-7 7s3.141 7 7 7 7-3.14 7-7a6.966 6.966 0 0 0-1.855-4.73zM15 18c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z"></path>
                <path d="M14 10h2v4h-2zm-1-7h4v2h-4zM3 8h4v2H3zm0 8h4v2H3zm-1-4h3.99v2H2z"></path>
            </svg>
            <b style="vertical-align: middle; color: #666;">15-20'</b>
            <!-- Icono de pago -->
            <svg class='atributo-pagina' style='fill: #e5213f' xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path d="M12 14c2.206 0 4-1.794 4-4s-1.794-4-4-4-4 1.794-4 4 1.794 4 4 4zm0-6c1.103 0 2 .897 2 2s-.897 2-2 2-2-.897-2-2 .897-2 2-2z"></path>
                <path d="M11.42 21.814a.998.998 0 0 0 1.16 0C12.884 21.599 20.029 16.44 20 10c0-4.411-3.589-8-8-8S4 5.589 4 9.995c-.029 6.445 7.116 11.604 7.42 11.819zM12 4c3.309 0 6 2.691 6 6.005.021 4.438-4.388 8.423-6 9.73-1.611-1.308-6.021-5.294-6-9.735 0-3.309 2.691-6 6-6z"></path>
            </svg>
            <b style="vertical-align: middle; color: #666;">3,49 €</b>
            <!-- Más información -->
            <a href="#" id='btnMostrarInformacion' class='enlace-valoracion' style='margin-left: 150px; '>
            <svg class='icon-svg' style='fill: #00a082' xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8z"></path>
                <path d="M11 11h2v6h-2zm0-4h2v2h-2z"></path>
            </svg>
            <b style="vertical-align: middle; color: #00a082;">Información</b>
            </a>
        </div>
        <!-- Formulario para insertar valoraciones -->
        <form id="valoracionForm" style='margin-top: 40px;' class='elemento-estilo'>
            <div id="rateYo" style="width: 180px;" ></div>
            <div class="counter" id='valoracion'></div>
            <!-- <span id="valoracion"></span> -->
            <label for="comentario" style='margin-top: 60px;'>Comentario:</label>
            <textarea id="comentario" name="comentario"></textarea>

            <!-- Añade un campo oculto para almacenar el id_usr -->
            <?php
            echo "<input type='hidden' id='id_usr' name='id_usr' value='" . $id_user . "'>"
            ?>

            <button type="button" id="btn_valoracion" class='enlace-valoracion' style='margin-left: 30px;'>Enviar Valoración</button>
        </form>
    </div>

    <div class='pagina'>
        <h2 class='contenido-pagina'>Productos</h2>
        <div id='producto' class="slt"></div>
    </div>
    <!-- Formulario para insertar valoraciones -->
    <div class='pagina'>
        <h2 class='contenido-pagina'>Comentarios</h2>
        <div id="comentarios_all" style="margin-top: 20px;"></div>
    </div>

    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</body>
<script>
    $(function() {

        $("#rateYo").rateYo({

            rating: 0,
            halfStar: true,
            spacing: "50px",
            multiColor: {
                "startColor": "#FF0000", //RED
                "endColor": "#FFD700" //GOLD
            },
            onChange: function(rating, rateYoInstance) {
                $("#valoracion").val(rating);
            }

        });

    });
</script>
<script src="./ajax.js"></script>
<script src="./mostrar_info.js"></script>
<script src="./valoracion.js"></script>
<script src="./mostrar_comentarios.js"></script>
<script src="./borrar_valoracion.js"></script>
<script src="./calcular_avg.js"></script>

</html>