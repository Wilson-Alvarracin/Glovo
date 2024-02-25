<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link rel="stylesheet" href="./../css/home.css">
    <title>Document</title>
</head>
<body>
<!-- Navbar -->
<nav class="navbar" id='navBar'>
    <div class="container-fluid">

        <a class="navbar-brand" href="#">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 95 32" class="glovo-logo header-logo__brand" data-v-13ec0cb2="" data-v-94e22206=""><path fill="#00A082" d="M0 20.944v-.062C0 14.947 4.527 9.917 10.894 9.917c3.169 0 5.28.758 7.211 2.152.363.273.755.787.755 1.514 0 1-.814 1.848-1.84 1.848-.483 0-.845-.211-1.147-.425-1.358-.998-2.836-1.666-5.13-1.666-3.892 0-6.85 3.424-6.85 7.482v.06c0 4.363 2.867 7.573 7.182 7.573 1.992 0 3.802-.636 5.1-1.605v-3.967H12.01c-.905 0-1.659-.698-1.659-1.606 0-.909.754-1.636 1.66-1.636h5.885c1.055 0 1.87.817 1.87 1.879v5.663c0 1.06-.422 1.818-1.298 2.363-1.811 1.212-4.346 2.302-7.513 2.302C4.345 31.848 0 27.123 0 20.944m23.093-9.905a1.8 1.8 0 0 1 1.81-1.818c1.026 0 1.842.818 1.842 1.818v18.78c0 1.03-.816 1.817-1.841 1.817a1.8 1.8 0 0 1-1.811-1.817v-18.78zm19.817 12.54v-.06c0-2.818-2.021-5.15-4.888-5.15-2.927 0-4.798 2.302-4.798 5.089v.06c0 2.787 2.022 5.119 4.858 5.119 2.957 0 4.828-2.302 4.828-5.058m-13.337 0v-.06c0-4.575 3.62-8.361 8.51-8.361 4.888 0 8.479 3.725 8.479 8.3v.06c0 4.544-3.621 8.33-8.54 8.33-4.86 0-8.449-3.725-8.449-8.269m26.105 8.209h-.18c-.997 0-1.661-.637-2.083-1.607l-5.31-12.206c-.092-.273-.212-.575-.212-.908 0-.91.815-1.757 1.81-1.757.996 0 1.51.574 1.811 1.333l4.104 10.6 4.164-10.66c.271-.636.755-1.273 1.72-1.273.996 0 1.78.757 1.78 1.757 0 .333-.12.697-.21.878L57.76 30.18c-.423.94-1.087 1.607-2.083 1.607m22.274-8.208v-.06c0-2.818-2.02-5.15-4.888-5.15-2.927 0-4.798 2.302-4.798 5.089v.06c0 2.787 2.022 5.119 4.86 5.119 2.955 0 4.826-2.302 4.826-5.058m-13.337 0v-.06c0-4.575 3.621-8.361 8.51-8.361 4.888 0 8.479 3.725 8.479 8.3v.06c0 4.544-3.62 8.33-8.54 8.33-4.858 0-8.449-3.725-8.449-8.269" class="glovo-logo__text--green" data-v-13ec0cb2=""></path><path fill="#00A082" d="m90.661 9.961-.2.28-2.751 3.897-2.748-3.89-.201-.282a3.648 3.648 0 0 1 2.949-5.781 3.65 3.65 0 0 1 2.95 5.776M87.711.639c-3.956 0-7.171 3.23-7.171 7.199 0 1.511.468 2.962 1.351 4.195l.19.266 3.735 5.288s.455.747 1.448.747h.892c.995 0 1.448-.747 1.448-.747l3.732-5.289.19-.266a7.155 7.155 0 0 0 1.352-4.195c0-3.969-3.217-7.198-7.17-7.198M85.692 21.58v-.014c0-1.076.851-1.966 2-1.966 1.15 0 1.994.876 1.994 1.952v.014c0 1.067-.852 1.957-2.008 1.957-1.14 0-1.986-.875-1.986-1.943" class="glovo-logo__balloon--green" data-v-13ec0cb2=""></path></svg>
        </a>
        <div id="session">
            <button id="loginButton" class="btn btn-custom" type="submit"><span class="spn-nav">Iniciar Sesion</span></button>
            <button id="RegisterButton" class="btn btn-custom" type="submit"><span class="spn-nav">Registrarse</span></button>
        </div>
    </div>
</nav>

<!-- Fin del NavBar -->
    <div id="section-1" class="slt flex">
        <div class="column-2 flex">
            <video autoplay="autoplay" loop="loop" muted="muted" >
                <source src="https://glovoapp.com/images/landing/address-container-animation.webm" preload="auto">
            </video>
        </div>
        <div class="column-2">
            <div class="cnt-ini">
                <div class="flex">
                    <h1><strong>Comida a domicilio y mucho más</strong></h1>
                </div>
                <div class="flex">
                    <p><strong>Supermercados, tiendas, farmacias, ¡lo que sea!</strong></p>
                </div>
            </div>
        </div>
    </div>
    <div class="margen int-1">
        <img src="https://glovoapp.com/images/waves/address-jumbotron-wave-desktop.svg" alt="" srcset="">
    </div>
    <div id="home">
        <!-- BUSCADOR CON FILTROS
        <div class="slt column-1 flex">
            <div id="buscador" class="">
                <div class="column-2">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                    </div>
                </div>
                <div class="column-4">
                <select class="form-select form-select-sm" aria-label="Default select example">
                    <option selected>Tipo de Cocina</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
                </div>
                <div class="column-4">
                <select class="form-select form-select-sm" aria-label="Default select example">
                    <option selected>Precio medio</option>
                    <option value="1">Economico 10€</option>
                    <option value="2">Antojos 15€</option>
                    <option value="3">Caprichos 20€</option>
                </select>
                </div>
            </div>
        </div>
    
        <div id="restaurantes" class="slt">
            <div class="column-4 flex">
                <div class="card">
                    <div class="card-img-top">
                        <a href="./view.php">
                            <img src="./../resorces/img/locales/15.png" class="card-img-top" alt="...">
                        </a>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">SushiSom</h3>
                        <div class="label">
                            <span class="label-name flex"><box-icon name='restaurant'></box-icon></box-icon>Asiática</span>
                        </div>
                        <div class="label">
                            <span class="label-name flex"><box-icon name='leaf' rotate='270' color='#00d40f'></box-icon>bug</span>
                        </div>
                        <P>valoracion: 4,5/5</P>
                        <p class="card-text">La Farga, Hospitalet de Llobregat</p>
                    </div>
                </div>
            </div> -->
    </div>
    <div class="int-1">
        <img src="https://glovoapp.com/images/landing/footer-wave-desktop.svg" alt="" srcset="">
    </div>
        <!-- INICIO DEL PIE DE PAGINA -->
  <footer class="site-footer">
      <div class="container">
        <div class="row">
          <div class="col-sm-12 col-md-6">
            <h6>ENCUENTRANOS EN</h6>
            <p class="text-justify">Scanfcode.com <i>CODE WANTS TO BE SIMPLE </i> is an initiative  to help the upcoming programmers with the code. Scanfcode focuses on providing the most efficient code or snippets as the code wants to be simple. We will help programmers build up concepts in different programming languages that include C, C++, Java, HTML, CSS, Bootstrap, JavaScript, PHP, Android, SQL and Algorithm.</p>
          </div>
  
          <div class="col-xs-6 col-md-3">
            <h6>LOCALES</h6>
            <ul class="footer-links">
              <li><a href="http://scanfcode.com/category/c-language/">C</a></li>
              <li><a href="http://scanfcode.com/category/front-end-development/">Plaza España</a></li>
              <li><a href="http://scanfcode.com/category/back-end-development/">Hospitalet de Llobregat</a></li>
            </ul>
          </div>
  
          <div class="col-xs-6 col-md-3">
            <h6>Más Sobre nosotros </h6>
            <ul class="footer-links">
              <li><a href="http://scanfcode.com/about/">About Us</a></li>
              <li><a href="http://scanfcode.com/contact/">Contact Us</a></li>
              <li><a href="http://scanfcode.com/privacy-policy/">Privacy Policy</a></li>
            </ul>
          </div>
        </div>
        <hr>
      </div>
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-sm-6 col-xs-12">
            <p class="copyright-text">Copyright &copy; 2024 All Rights Reserved by 
            <a href="#">Pizza Mans</a>.
            </p>
          </div>
  
          <div class="col-md-4 col-sm-6 col-xs-12">
            <ul class="social-icons">
              <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
              <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
              <li><a class="dribbble" href="#"><i class="fa-brands fa-instagram"></i></a></li> 
            </ul>
          </div>
        </div>
      </div>
  </footer>  
    <script src="./../js/home.js"></script>
<!-- <script src="./../js/script.js"></script> -->
</body>
</html>