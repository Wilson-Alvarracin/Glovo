<?php

$host = 'localhost';
$username = 'root';
$password_db = '';
$database = 'db_glovo';

$conn = new mysqli($host, $username, $password_db, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

//Login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $host = 'localhost';
    $username = 'root';
    $password_db = '';
    $database = 'db_glovo';

    $conn = new mysqli($host, $username, $password_db, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT usr_pwd FROM tbl_usr WHERE usr_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedPassword = $row['usr_pwd'];
    
        // Verificar la contraseña usando password_verify
        if (password_verify($password, $storedPassword)) {
            // Contraseña válida
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;
    
            header("Location: index.php");
            exit();
        } else {
            // Contraseña no válida
            echo "<p style='color: red; font-size: 12px;'>Invalid email or password</p>";
            echo "<br>";
        }
    } else {
        // Usuario no encontrado
        echo "<p style='color: red; font-size: 12px;'>Invalid email or password</p>";
        echo "<br>";
    }
    
    $stmt->close();
    $conn->close();
}



//Registrar

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registerUser']) && isset($_POST['registerEmail']) && isset($_POST['registerPassword']) && isset($_POST['registerLastName'])) {
    $host = 'localhost';
    $username = 'root';
    $password_db = '';
    $database = 'db_glovo';

    $conn = new mysqli($host, $username, $password_db, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Manejar el formulario de registro
    $user = $_POST["registerUser"];
    $password = $_POST["registerPassword"];
    $email = $_POST["registerEmail"];
    $apellido = $_POST["registerLastName"];

    try {
        // Verificar si el nombre de usuario ya existe
        $stmtVerificacion = $conn->prepare("SELECT * FROM tbl_usr WHERE usr_nom = ?");
        $stmtVerificacion->bind_param('s', $user);
        $stmtVerificacion->execute();
        $stmtVerificacion->store_result();
        $userExists = $stmtVerificacion->num_rows > 0;

        if ($userExists) {
            echo "Error Nombre";
            exit();
        }

        // Verificar si el correo electrónico ya está registrado
        $stmtCorreo = $conn->prepare("SELECT * FROM tbl_usr WHERE usr_email = ?");
        $stmtCorreo->bind_param('s', $email);
        $stmtCorreo->execute();
        $stmtCorreo->store_result();
        $emailExists = $stmtCorreo->num_rows > 0;

        if ($emailExists) {
            echo "Error correo";
            exit();
        }

        // Hashear la contraseña
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insertar el nuevo usuario en la base de datos
        $stmt = $conn->prepare("INSERT INTO tbl_usr (usr_nom, usr_ape, usr_email, usr_pwd, usr_rol) VALUES (?, ?, ?, ?, 'user')");
        $stmt->bind_param('ssss', $user, $apellido, $email, $hashed_password);

        if ($stmt->execute()) {
            echo "<p>Usuario Insertado</p>";
            echo "<a href='./home.php'>Volver Login</a>";
            exit();
        } else {
            echo "<p style='color: red; font-size: 12px;'>Invalid email or password</p>";
            echo "<br>";
        }
    } catch (Exception $e) {
        // Manejo de errores de la base de datos
        echo "Error de la base de datos: " . $e->getMessage();
    }
}



?>


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
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body>
    <b>Comida a domicilio y mucho más</b>


    <button type="button" class="btn btn-success btn-custom" id="LoginButton"><b>Login</b></button>
    <button type="button" class="btn btn-success btn-custom" id="RegisterButton"><b>Registrar</b></button>


    <script>
        // Selecciona el botón por su id
        var boton = document.getElementById('LoginButton');
        var boton2 = document.getElementById('RegisterButton');

        // Agrega el evento click al botón
        boton.addEventListener('click', function() {
            Swal.fire({
                title: `<b class='margen'>¡Hola!</b>`,
                html: `<div style='height: 400px;'>
                    <div style='margin-bottom: 30px; font-size: 15px;'>
                        <b style='color:grey;'>Comencemos por tu número de teléfono</b>
                    </div>
                <form id='loginForm' method="POST">
                    <div>
                        <input type="text" id="email" name="email" class="inputs" placeholder="Correo electrónico...">
                        <p id='emailError' style='color: red; font-size: 12px;'></p>
                    </div>
                    <div>
                        <input type="password" id="password" name="password" class="inputs" placeholder="Contraseña...">
                        <p id='passwordError' style='color: red; font-size: 12px;'></p>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success btn-custom2"><b>Continuar</b></button>
                    </div>
                </form>
                </div>
                `,
                showConfirmButton: false,
                showCloseButton: true,
                width: '500px'
            });

            var emailField = document.getElementById('email');
            var passwordField = document.getElementById('password');

            var form = document.getElementById('loginForm');

            var emailError = document.getElementById('emailError');
            var passwordError = document.getElementById('passwordError');

            const patronEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/; // Formato de email
            const patronContrasena = /^(?=.*\d)(?=.*[A-Z])[0-9a-zA-Z]{8,}$/; // Al menos 1 número, 1 mayúscula, mínimo 8 caracteres


            // Validaciones email
            emailField.addEventListener('blur', function() {
                const email = emailField.value;
                if (email === "") {
                    emailError.innerHTML = "Ingresa un correo electrónico.";
                    emailField.style.borderColor = 'red';
                } else if (!patronEmail.test(email)) {
                    emailError.innerHTML = "El email no es válido, debe estar escrito con la siguiente pauta: ejemplo@ejemplo.com";
                    emailField.style.borderColor = 'red';
                } else {
                    emailError.innerHTML = "";
                    emailField.style.borderColor = 'black';
                }
            });

            passwordField.addEventListener('blur', function() {
                const contrasena = passwordField.value;
                if (contrasena === "") {
                    passwordError.innerHTML = "Ingresa una contraseña.";
                    passwordField.style.borderColor = 'red';
                } else if (!patronContrasena.test(contrasena)) {
                    passwordError.innerHTML = "La contraseña debe tener al menos 1 número, 1 mayúscula y mínimo 8 carácteres.";
                    passwordField.style.borderColor = 'red';
                } else {
                    passwordError.innerHTML = "";
                    passwordField.style.borderColor = 'black';
                }
            });

            form.addEventListener('submit', function(event) {
                const email = emailField.value.trim();
                const contrasena = passwordField.value.trim();

                emailError.innerHTML = "";
                passwordError.innerHTML = "";

                // Validaciones email
                if (email === "") {
                    emailError.innerHTML = "Ingresa un correo electrónico.";
                    emailField.style.borderColor = 'red';
                    event.preventDefault();
                } else if (!patronEmail.test(email)) {
                    emailError.innerHTML = "El email no es válido, debe estar escrito con la siguiente pauta: ejemplo@ejemplo.com";
                    emailField.style.borderColor = 'red';
                    event.preventDefault();
                }

                // Validaciones password
                if (contrasena === "") {
                    passwordError.innerHTML = "Ingresa una contraseña.";
                    passwordField.style.borderColor = 'red';
                    event.preventDefault();
                } else if (!patronContrasena.test(contrasena)) {
                    passwordError.innerHTML = "La contraseña debe tener al menos 1 número, 1 mayúscula y mínimo 8 carácteres.";
                    passwordField.style.borderColor = 'red';
                    event.preventDefault();
                }
            });
        });

        // Agrega el evento al botón
        boton2.addEventListener('click', function() {
            Swal.fire({
                title: `<b class='margen'>¡Hola!</b>`,
                html: `<div style='height: 400px;'>
            <div style='margin-bottom: 30px; font-size: 15px;'>
                <b style='color:grey;'>Comencemos por tus datos de registro</b>
            </div>
            <form id='registerForm' method="POST">
                <div>
                    <input type="text" id="registerUser" name="registerUser" class="inputs" placeholder="Nombre de Usuario...">
                    <p id='registerUserError' style='color: red; font-size: 12px;'></p>
                </div>
                <div>
                    <input type="text" id="registerLastName" name="registerLastName" class="inputs" placeholder="Apellido...">
                    <p id='registerLastNameError' style='color: red; font-size: 12px;'></p>
                </div>
                <div>
                    <input type="email" id="registerEmail" name="registerEmail" class="inputs" placeholder="Correo Electrónico...">
                    <p id='registerEmailError' style='color: red; font-size: 12px;'></p>
                </div>
                <div>
                    <input type="password" id="registerPassword" name="registerPassword" class="inputs" placeholder="Contraseña...">
                    <p id='registerPasswordError' style='color: red; font-size: 12px;'></p>
                </div>
                <div>
                    <button type="submit" class="btn btn-success btn-custom2"><b>Registrarse</b></button>
                </div>
            </form>
        </div>`,
                showConfirmButton: false,
                showCloseButton: true,
                width: '500px'
            });

            var registerUserField = document.getElementById('registerUser');
            var registerLastNameField = document.getElementById('registerLastName');
            var registerEmailField = document.getElementById('registerEmail');
            var registerPasswordField = document.getElementById('registerPassword');

            var registerForm = document.getElementById('registerForm');

            var registerUserError = document.getElementById('registerUserError');
            var registerLastNameError = document.getElementById('registerLastNameError');
            var registerEmailError = document.getElementById('registerEmailError');
            var registerPasswordError = document.getElementById('registerPasswordError');

            const patronNombreUsuario = /^[a-zA-Z0-9_]{3,20}$/; // Formato de nombre de usuario
            const patronApellido = /^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]{1,50}$/; // Formato de apellido
            const patronEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/; // Formato de email
            const patronContrasena = /^(?=.*\d)(?=.*[A-Z])[0-9a-zA-Z]{8,}$/; // Al menos 1 número, 1 mayúscula, mínimo 8 caracteres

            // Validaciones nombre de usuario
            registerUserField.addEventListener('blur', function() {
                const userName = registerUserField.value;
                if (userName === "") {
                    registerUserError.innerHTML = "Ingresa un nombre de usuario.";
                    registerUserField.style.borderColor = 'red';
                } else if (!patronNombreUsuario.test(userName)) {
                    registerUserError.innerHTML = "El nombre de usuario debe contener solo letras, números y guiones bajos (_), y tener entre 3 y 20 caracteres.";
                    registerUserField.style.borderColor = 'red';
                } else {
                    registerUserError.innerHTML = "";
                    registerUserField.style.borderColor = 'black';
                }
            });

            // Validaciones apellido
            registerLastNameField.addEventListener('blur', function() {
                const lastName = registerLastNameField.value;
                if (lastName === "") {
                    registerLastNameError.innerHTML = "Ingresa un apellido.";
                    registerLastNameField.style.borderColor = 'red';
                } else if (!patronApellido.test(lastName)) {
                    registerLastNameError.innerHTML = "El apellido debe contener solo letras y tener hasta 50 caracteres.";
                    registerLastNameField.style.borderColor = 'red';
                } else {
                    registerLastNameError.innerHTML = "";
                    registerLastNameField.style.borderColor = 'black';
                }
            });

            // Validaciones email
            registerEmailField.addEventListener('blur', function() {
                const email = registerEmailField.value;
                if (email === "") {
                    registerEmailError.innerHTML = "Ingresa un correo electrónico.";
                    registerEmailField.style.borderColor = 'red';
                } else if (!patronEmail.test(email)) {
                    registerEmailError.innerHTML = "El email no es válido, debe estar escrito con la siguiente pauta: ejemplo@ejemplo.com";
                    registerEmailField.style.borderColor = 'red';
                } else {
                    registerEmailError.innerHTML = "";
                    registerEmailField.style.borderColor = 'black';
                }
            });

            // Validaciones password
            registerPasswordField.addEventListener('blur', function() {
                const password = registerPasswordField.value;
                if (password === "") {
                    registerPasswordError.innerHTML = "Ingresa una contraseña.";
                    registerPasswordField.style.borderColor = 'red';
                } else if (!patronContrasena.test(password)) {
                    registerPasswordError.innerHTML = "La contraseña debe tener al menos 1 número, 1 mayúscula y mínimo 8 caracteres.";
                    registerPasswordField.style.borderColor = 'red';
                } else {
                    registerPasswordError.innerHTML = "";
                    registerPasswordField.style.borderColor = 'black';
                }
            });

            // Validaciones al enviar el formulario
            registerForm.addEventListener('submit', function(event) {
                const userName = registerUserField.value.trim();
                const lastName = registerLastNameField.value.trim();
                const email = registerEmailField.value.trim();
                const password = registerPasswordField.value.trim();

                registerUserError.innerHTML = "";
                registerLastNameError.innerHTML = "";
                registerEmailError.innerHTML = "";
                registerPasswordError.innerHTML = "";

                // Validaciones nombre de usuario
                if (userName === "") {
                    registerUserError.innerHTML = "Ingresa un nombre de usuario.";
                    registerUserField.style.borderColor = 'red';
                    event.preventDefault();
                } else if (!patronNombreUsuario.test(userName)) {
                    registerUserError.innerHTML = "El nombre de usuario debe contener solo letras, números y guiones bajos (_), y tener entre 3 y 20 caracteres.";
                    registerUserField.style.borderColor = 'red';
                    event.preventDefault();
                }

                // Validaciones apellido
                if (lastName === "") {
                    registerLastNameError.innerHTML = "Ingresa un apellido.";
                    registerLastNameField.style.borderColor = 'red';
                    event.preventDefault();
                } else if (!patronApellido.test(lastName)) {
                    registerLastNameError.innerHTML = "El apellido debe contener solo letras y tener hasta 50 caracteres.";
                    registerLastNameField.style.borderColor = 'red';
                    event.preventDefault();
                }

                // Validaciones email
                if (email === "") {
                    registerEmailError.innerHTML = "Ingresa un correo electrónico.";
                    registerEmailField.style.borderColor = 'red';
                    event.preventDefault();
                } else if (!patronEmail.test(email)) {
                    registerEmailError.innerHTML = "El email no es válido, debe estar escrito con la siguiente pauta: ejemplo@ejemplo.com";
                    registerEmailField.style.borderColor = 'red';
                    event.preventDefault();
                }

                // Validaciones password
                if (password === "") {
                    registerPasswordError.innerHTML = "Ingresa una contraseña.";
                    registerPasswordField.style.borderColor = 'red';
                    event.preventDefault();
                } else if (!patronContrasena.test(password)) {
                    registerPasswordError.innerHTML = "La contraseña debe tener al menos 1 número, 1 mayúscula y mínimo 8 caracteres.";
                    registerPasswordField.style.borderColor = 'red';
                    event.preventDefault();
                }
            });
        });
    </script>
</body>

</html>