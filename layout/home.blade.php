<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- Incluir SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <b>Comida a domicilio y mucho má ASDASs</b>

    <button type="button" class="btn btn-success btn-custom" id="formButton"><b>Comenzar</b></button>

    <script>
        // Selecciona el botón por su id
        var boton = document.getElementById('formButton');
    
        // Agrega el evento click al botón
        boton.addEventListener('click', function() {
            Swal.fire({
                title: `<b class='margen'>¡Hola!</b>`,
                html: `<div style='height: 400px;'>
                    <div style='margin-bottom: 30px; font-size: 15px;'>
                        <b style='color:grey;'>Comencemos por tu número de teléfono</b>
                    </div>
                <form action="/login" method="POST">
                    <div>
                        <input type="email" id="email" name="email" class="inputs" placeholder="Correo electrónico...">
                        <p id='emailError' style='color: red;'></p>
                    </div>
                    <div>
                        <input type="password" id="password" name="password" class="inputs" placeholder="Contraseña...">
                    </div>
                    <div>
                        <button type="button" class="btn btn-success btn-custom2"><b>Continuar</b></button>
                    </div>
                </form>
                </div>
                `,
                showConfirmButton: false,
                showCloseButton: true,
                width: '500px'
            });

            var emailField = document.getElementById('email');
            var emailError = document.getElementById('emailError');
            const patronEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/; // Formato de email


    // Validaciones email
            emailField.addEventListener('blur', function() {
                const email = emailField.value;
                if (email === "") {
                    emailError.innerHTML = "Ingresa un correo electrónico.";
                } else if (!patronEmail.test(email)) {
                    emailError.innerHTML = "El email no es válido, debe estar escrito con la siguiente pauta: ejemplo@ejemplo.com";
                } else {
                    emailError.innerHTML = "";
                }
            });
        });
    </script>
    <script src="../js/script.js"></script>
</body>
</html>