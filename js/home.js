document.addEventListener('DOMContentLoaded', function() {
    home();

});


function home() {
    fetch("../proc/proc_home.php")
    .then(sapo => sapo.text())
    .then(home =>{ 
        document.getElementById('home').innerHTML = home
        addFiltros()
    })
}

function addFiltros()
{
    document.getElementById("cocina").addEventListener("change",filtro)
    document.getElementById("precio").addEventListener("change",filtro)
    document.getElementById("local").addEventListener("keyup",filtro)
}


function filtro() {

    var filtros = {
        cocina: document.getElementById('cocina').value,
        precio:  document.getElementById('precio').value,
        local: document.getElementById('local').value
    }
    fetch("../proc/proc_filtros.php",{
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'datos=' + encodeURIComponent(JSON.stringify(filtros))
    })
    .then(contenido =>contenido.text())
    .then(texto => document.getElementById('restaurantes').innerHTML = texto)
}

// FUNCIONALIDAD BOTONES DE LOGIN Y VALIDACION DEL FORM
        // Selecciona el botón por su id
        var boton = document.getElementById('LoginButton');
        var boton2 = document.getElementById('RegisterButton');

        // Agrega el evento click al botón
        boton.addEventListener('click', function() {
            Swal.fire({
                title: `<b class='margen'>¡Hola!</b>`,
                html: `<div style='height: 400px;'>
                <form id='loginForm' method="POST">
                    <div>
                        <input type="text" id="email" name="loginEmail" class="inputs" placeholder="Correo electrónico...">
                        <p id='emailError' style='color: red; font-size: 12px;'></p>
                    </div>
                    <div>
                        <input type="password" id="password" name="loginPassword" class="inputs" placeholder="Contraseña...">
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
            emailField.addEventListener('keyup', function() {
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

            passwordField.addEventListener('keyup', function() {
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
                    <input type="text" id="registerEmail" name="registerEmail" class="inputs" placeholder="Correo Electrónico...">
                    <p id='registerEmailError' style='color: red; font-size: 12px;'></p>
                </div>
                <div>
                    <input type="password" id="registerPassword" name="registerPassword" class="inputs" placeholder="Contraseña...">
                    <p id='registerPasswordError' style='color: red; font-size: 12px;'></p>
                </div>
                <div>
                    <input type="password" id="confirmPassword" name="confirmPassword" class="inputs" placeholder="Confirmar Contraseña...">
                    <p id='confirmPasswordError' style='color: red; font-size: 12px;'></p>
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

            var confirmPasswordField = document.getElementById('confirmPassword');

            var confirmPasswordError = document.getElementById('confirmPasswordError');

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
            registerLastNameField.addEventListener('keyup', function() {
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
            registerEmailField.addEventListener('keyup', function() {
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
            registerPasswordField.addEventListener('keyup', function() {
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

            confirmPasswordField.addEventListener('keyup', function() {
                const confirmPassword = confirmPasswordField.value;
                const password = registerPasswordField.value;

                if (confirmPassword === "") {
                    confirmPasswordError.innerHTML = "Confirma tu contraseña.";
                    confirmPasswordField.style.borderColor = 'red';
                } else if (password !== confirmPassword) {
                    confirmPasswordError.innerHTML = "Las contraseñas no coinciden.";
                    confirmPasswordField.style.borderColor = 'red';
                } else {
                    confirmPasswordError.innerHTML = "";
                    confirmPasswordField.style.borderColor = 'black';
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

                const confirmPassword = confirmPasswordField.value.trim();

                confirmPasswordError.innerHTML = "";

                // Validaciones confirmar contraseña
                if (confirmPassword === "") {
                    confirmPasswordError.innerHTML = "Confirma tu contraseña.";
                    confirmPasswordField.style.borderColor = 'red';
                    event.preventDefault();
                } else if (password !== confirmPassword) {
                    confirmPasswordError.innerHTML = "Las contraseñas no coinciden.";
                    confirmPasswordField.style.borderColor = 'red';
                    event.preventDefault();
                }
            });
        });