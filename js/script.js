document.addEventListener('DOMContentLoaded', function() {
    // var boton = document.getElementById('formButton');
    document.getElementById('headerInput').addEventListener('click',Sesion);
});

document.addEventListener('DOMContentLoaded', function() {

    const headerInput = document.getElementById('headerInput');

    // Guardar el contenido original del encabezado incluyendo su HTML
    const originalHeaderHTML = document.getElementById('navBar').innerHTML;
    var valor = document.getElementById('input');

    // Dentro del evento scroll
    window.addEventListener('scroll', function() {
        const scrollPosition = window.scrollY;
        const header = document.getElementById('navBar');

        let inputValue = '';
        // Evento para detectar cambios en el input
        header.addEventListener('input', function(event) {
            inputValue = event.target.value;
        });

        if (scrollPosition > 600 ) {
            if (!header.classList.contains('input-restaurante')) {
                header.classList.add('input-restaurante'); // Agregamos la clase del input
                header.innerHTML = originalHeaderHTML + `
                    <div class="input-group mb-3 bottom-input">
                        <span class="input-group-text green" id="basic-addon1"><i class="bi bi-search"></i></span>
                        <input id='bottomInput' type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                    </div>`;
            }
        } else if (scrollPosition > 0) {
            if (!header.classList.contains('scrolled')) {
                header.classList.add('scrolled'); // Agregamos la clase del scroll
            } else {
                header.innerHTML = originalHeaderHTML; // Restaurar el contenido original
                header.classList.remove('input-restaurante'); // Borramos la clase del input
            }
        } else {
            header.classList.remove('scrolled'); // Borramos la clase del scroll
            header.innerHTML = originalHeaderHTML; // Restaurar el contenido original
        }
    });
    });

// Selecciona el botón por su id
    
function Sesion() {
    Swal.fire({
        title: `<b class='margen'>¡Hola!</b>`,
        html: `<div style='height: 400px;'>
            <div style='margin-bottom: 30px; font-size: 15px;'>
                <b style='color:grey;'>Comencemos por tu número de teléfono</b>
            </div>
        <form id='loginForm' action="./pagina.blade.php" method="POST" class="form-floating">
            <div>
                <input type="email" id="email" name="email" class="inputs" placeholder="Correo electrónico...">
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

    emailField.addEventListener('blur', function() {
        const email = emailField.value;
        if (email === "") {
            emailError.innerHTML = "Ingresa un correo electrónico.";
            emailField.classList += ' is-invalid'
        } else if (!patronEmail.test(email)) {
            emailError.innerHTML = "El email no es válido, debe estar escrito con la siguiente pauta: ejemplo@ejemplo.com";
            emailField.style.borderColor = 'red';
        } else {
            emailError.innerHTML = "";
            emailField.style.borderColor = 'black';
        }
    });
    passwordField.addEventListener('blur', function(){
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
}