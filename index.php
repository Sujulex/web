<?php 
session_start();

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <title> MUSIC BLOG </title>
<!--

Template 2101 Insertion

http://www.tooplate.com/view/2101-insertion

-->
  <!-- load CSS -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400">        <!-- Google web font "Open Sans" -->
  <link rel="stylesheet" href="css/bootstrap.min.css">                                            <!-- https://getbootstrap.com/ -->
  <link rel="stylesheet" href="css/fontawesome-all.min.css">                                      <!-- Font awesome -->
  <link rel="stylesheet" href="css/tooplate-style.css">        
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
                                   <!-- Templatemo style -->

  <script>
    var renderPage = true;

    if (navigator.userAgent.indexOf('MSIE') !== -1
      || navigator.appVersion.indexOf('Trident/') > 0) {
      /* Microsoft Internet Explorer detected in. */
      alert("Please view this in a modern browser such as Chrome or Microsoft Edge.");
      renderPage = false;
    }
  </script>
<!-- Justo antes del </body> -->
</head>


<body>

  <!-- Loader -->
  <div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
  </div>

  <div class="tm-main">

 <!-- Carrusel -->
 <div class="slider-container position-relative">
  <div id="carouselExampleIndicators" class="carousel slide tm-welcome-section" data-ride="carousel" data-interval="3000">
    <ol class="carousel-indicators">
      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
    </ol>
    <div class="carousel-inner">
      <!-- Primer slide -->
      <div class="carousel-item active">
        <img class="d-block w-100" src="img_blog_musica/Carrusel1.jpg" alt="Slide 1">
      </div>
      <!-- Segundo slide -->
      <div class="carousel-item">
        <img class="d-block w-100" src="img_blog_musica/Carrusel2.jpg" alt="Slide 2">
      </div>
      <!-- Tercer slide -->
      <div class="carousel-item">
        <img class="d-block w-100" src="img_blog_musica/Carrusel3.jpg" alt="Slide 3">
      </div>
      <!-- Cuarto slide -->
      <div class="carousel-item">
        <img class="d-block w-100" src="img_blog_musica/Carrusel4.jpg" alt="Slide 4">
      </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Anterior</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Siguiente</span>
    </a>
  </div>
  <!-- Texto central para todos los slides -->
  <div class="carousel-caption d-none d-md-block">
    <i class="fas tm-fa-big fa-music tm-fa-mb-big"></i>
    <h1 class="text-uppercase mb-3 tm-site-name">MUSIC BLOG</h1>
    <p class="tm-site-description">La mejor música en la actualidad</p>
  </div>
</div> 

<!-- Estilos para el slider -->
<style>
  /* Estilos para las imágenes del carrusel */
  .carousel-item img {
    height: 100vh;  
    object-fit: cover; 
    width: 100%;
  }

  /* Estilos para el contenedor de los textos */
  .carousel-caption {
    background-color: rgba(0, 0, 0, 0.4); /* Fondo oscuro suave */
    padding: 1rem;
    border-radius: 10px;
    position: absolute; 
    top: 50%; 
    left: 50%;
    transform: translate(-50%, -50%); 
    text-align: center; 
    width: 100%;
    z-index: 10;
  }

  /* Estilos para el título grande (h1) */
  .carousel-caption h1 {
    font-family: 'Roboto', sans-serif; /* Fuente bonita */
    font-weight: 900;
    font-size: 7rem; /* Tamaño grande para el título */
    color: #f1c40f; /* Color dorado */
    -webkit-text-stroke: 2px black; /* Borde negro por letra */
    text-stroke: 2px black;
    letter-spacing: 3px;
    margin-bottom: 20px;
    text-transform: uppercase;
  }

  /* Estilos para el párrafo pequeño */
  .carousel-caption p {
    font-family: 'Roboto', sans-serif;
    font-weight: 700;
    font-size: 2.5rem; /* Un poco más pequeño que el h1 */
    color: white;
    -webkit-text-stroke: 1px black; /* También borde para p */
    text-stroke: 1px black;
    letter-spacing: 2px;
  }

  /* Estilos para los botones del carrusel */
  .carousel-control-prev,
  .carousel-control-next {
    z-index: 20;
  }

  /* Fondo transparente */
  .carousel, .carousel-inner {
    background: none !important;
  }

  .slider-container {
    margin-bottom: 100px; 
  }

  .tm-main {
    padding-top: 0;
    margin-top: 0 !important;
  }
</style>






<!-- El contenido de la barra de navegación -->
<div class="container-fluid tm-navbar-container">
  <div class="row">
    <div class="col-xl-12">
    <nav class="navbar navbar-expand-sm" style="font-family: 'Open Sans', Helvetica, Arial, sans-serif; position: relative; z-index: 50;">
        <!-- Menú Izquierdo -->
        <ul class="navbar-nav align-items-center">
  <?php if (isset($_SESSION['auth']) && $_SESSION['auth'] && isset($_SESSION['rol_id']) && $_SESSION['rol_id'] == 1): ?>  
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle tm-nav-link tm-text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border: 1px solid white; padding: 5px 10px; border-radius: 5px;">
        Administración
      </a>
      <div class="dropdown-menu dropdown-menu-right bg-dark border-0" aria-labelledby="navbarDropdown">
        <a class="dropdown-item text-white" href="Admi/usuarios.php" >usuarios</a>
      </div>
    </li>
  <?php endif; ?>
</ul>




        <!-- Menú Derecho -->
        <ul class="navbar-nav ml-auto align-items-center pr-4">
          <!-- Menú normal -->
          <li class="nav-item active">
            <a href="index.php" class="nav-link tm-nav-link tm-text-white active">Inicio</a>
          </li>
          <li class="nav-item">
            <a href="Artistas.php" class="nav-link tm-nav-link tm-text-white">Artistas</a>
          </li>
          <li class="nav-item">
            <a href="Canciones.php" class="nav-link tm-nav-link tm-text-white">Canciones</a>
          </li>
          <li class="nav-item">
            <a href="Albumes.php" class="nav-link tm-nav-link tm-text-white">Álbumes</a>
          </li>

          <!-- Sesión iniciada o no -->
          <?php if (isset($_SESSION['auth']) && $_SESSION['auth']): ?>
            <!-- Usuario logueado -->
            <li class="nav-item d-flex align-items-center">
              <span class="nav-link tm-nav-link tm-text-white d-flex align-items-center">
                <i class="fas fa-user-circle mr-2"></i> <?= htmlspecialchars($_SESSION['nombre']) ?>
              </span>
              <li>
                <a href="salir.php" class="nav-link tm-nav-linkIS tm-text-white" style="border: 1px solid white; padding: 5px 10px; border-radius: 5px; margin-left: 10px;">
                  Salir
                </a>
              </li>
            </li>
          <?php else: ?>
            <!-- Usuario no logueado -->
            <li>
              <a href="login.php" class="nav-link tm-nav-linkIS tm-text-white" style="border: 1px solid white; padding: 5px 10px; border-radius: 5px;">
                Iniciar sesión
              </a>
            </li>
          <?php endif; ?>

        </ul>
      </nav>
    </div>
  </div>
</div>






      

    <!-- Buscador musical -->
    <div class="container my-5">
  <div class="tm-search-form-container text-center p-5 rounded shadow-lg" style="background-color:rgb(168, 227, 218);">
    <h2 class="mb-4 text-uppercase">Buscador musical</h2>
    <p class="mb-4">Explora millones de canciones, artistas y álbumes</p>
    <form action="buscar.php" method="GET" class="form d-flex justify-content-center">
  <div class="form-group tm-search-box d-flex">
    <input 
      type="text" 
      name="keyword" 
      class="form-control tm-search-input me-2 custom-input"
      placeholder="Escribe aquí..." 
      onfocus="this.placeholder=''" 
      onblur="this.placeholder='Escribe aquí...'"
    >
    <input type="submit" value="Buscar" class="btn tm-search-submit">
  </div>
</form>

  </div>
</div>




<section class="tm-latest-news">
  <h2>ÚLTIMAS NOVEDADES</h2>
</section>




<div class="container-fluid">
  <div class="row tm-albums-container">
    <div class="col-12 col-md-6 col-lg-3 tm-album-col">
      <figure class="effect-sadie">
        <img src="img_blog_musica/Novedades1.jpg" alt="Image" class="img-fluid album-img">
        <figcaption>
          <h2>"SAGITARIO"</h2>
          <p>Disponible el nuevo álbum de Paty Cantú en Spotify</p>
        </figcaption>
      </figure>
    </div>

    <div class="col-12 col-md-6 col-lg-3 tm-album-col">
      <figure class="effect-sadie">
        <img src="img_blog_musica/Novedades2.jpeg" alt="Image" class="img-fluid album-img">
        <figcaption>
          <h2>DON OMAR EN OAXACA</h2>
          <p>Auditorio Guelaguetza lleno en concierto de Don Omar</p>
        </figcaption>
      </figure>
    </div>

    <div class="col-12 col-md-6 col-lg-3 tm-album-col">
      <figure class="effect-sadie">
        <img src="img_blog_musica/Novedades3.1.jpeg" alt="Image" class="img-fluid album-img">
        <figcaption>
          <h2>LEIRE MARTÍNEZ</h2>
          <p>Nuevo sencillo tras salir de La Oreja de Van Gogh: "Mi Nombre"</p>
        </figcaption>
      </figure>
    </div>

    <div class="col-12 col-md-6 col-lg-3 tm-album-col">
      <figure class="effect-sadie">
        <img src="img_blog_musica/Novedades4.jpeg" alt="Image" class="img-fluid album-img">
        <figcaption>
          <h2>Santa Fe Klan y Danna Paola</h2>
          <p>"Nada es para siempre" rompe récords en playlists latinas</p>
        </figcaption>
      </figure>
    </div>
  </div>
</div>






<div class="row">
  <div class="col-lg-12">
    <div class="tm-tag-line">
      <h2 class="tm-tag-line-title">"LOS ARTISTAS DEL MOMENTO"</h2>
    </div>
  </div>
</div>







<div class="row mb-5">
  <div class="col-xl-12">
    <div class="media-boxes">

      <!-- Tarjeta 1 -->
      <div class="media tm-bg-light-blue">
        <img src="img_blog_musica/ADM1.jpg" alt="Image" class="media-img mr-3">
        <div class="media-body tm-bg-light-blue">
          <div class="content-container">
            <div class="tm-description-box">
              <h3 class="artist-name artist-dua-lipa">DUA LIPA</h3>
              <p class="artist-description">"Con su fusión de pop, disco y estilo elegante en su álbum -Future Nostalgia-, Dua Lipa redefine la música contemporánea y domina las listas globales.".</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Tarjeta 2 -->
      <div class="media tm-bg-light-pink">
        <img src="img_blog_musica/ADM2.jpg" alt="Image" class="media-img mr-3">
        <div class="media-body tm-bg-light-pink">
          <div class="content-container">
            <div class="tm-description-box">
              <h3 class="artist-name artist-sebastian-yatra">SEBASTIAN YATRA</h3>
              <p class="artist-description">"Sebastián Yatra conquista corazones con su versatilidad musical, moviéndose entre el pop y las baladas con una autenticidad irresistible."</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Tarjeta 3 -->
      <div class="media tm-bg-light-yellow">
        <img src="img_blog_musica/ADM3.jpg" alt="Image" class="media-img mr-3">
        <div class="media-body tm-bg-light-yellow">
          <div class="content-container">
            <div class="tm-description-box">
              <h3 class="artist-name artist-danna-paola">DANNA PAOLA</h3>
              <p class="artist-description">"Danna Paola brilla como un ícono pop latino, combinando talento actoral y una poderosa voz que conecta con nuevas generaciones."</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Tarjeta 4 -->
      <div class="media tm-bg-light-green">
        <img src="img_blog_musica/ADM4.1.jpeg" alt="Image" class="media-img mr-3">
        <div class="media-body tm-bg-light-green">
          <div class="content-container">
            <div class="tm-description-box">
              <h3 class="artist-name artist-lady-gaga">LADY GAGA</h3>
              <p class="artist-description">"Lady Gaga sigue marcando la cultura pop con su innovación artística, su poderosa voz y su compromiso social inquebrantable.".</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Tarjeta 5 -->
      <div class="media tm-bg-light-purple">
        <img src="img_blog_musica/ADM5.1.jpg" alt="Image" class="media-img mr-3">
        <div class="media-body tm-bg-light-purple">
          <div class="content-container">
            <div class="tm-description-box">
              <h3 class="artist-name artist-reik">REIK</h3>
              <p class="artist-description">"Reik evoluciona su sonido constantemente, pasando del pop romántico a las tendencias urbanas, manteniéndose relevantes en la escena latina.".</p>
            </div>
          </div>
        </div>
      </div>

    </div> <!-- media-boxes -->
  </div>
</div>




















      
 <!--
      <div class="row tm-mb-big tm-subscribe-row">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 tm-bg-gray tm-subscribe-form">
          <h3 class="tm-text-pink tm-mb-30">Subscribe our updates!</h3>
          <p class="tm-mb-30">Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Morbi semper, ligula et pretium porttitor, leo orci accumsan ligula.</p>
          <form action="index.html" method="POST">
            <div class="form-group mb-0">
              <input type="text" class="form-control tm-subscribe-input" placeholder="Your Email">
              <input type="submit" value="Submit" class="tm-bg-pink tm-text-white d-block ml-auto tm-subscribe-btn">
            </div>
          </form>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 img-fluid pl-0 tm-subscribe-img"></div>
      </div>

      <div class="row tm-mb-medium">
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 mb-4">
          <h4 class="mb-4 tm-font-300">Latest Albums</h4>
          <a href="#" class="tm-text-blue-dark d-block mb-2">Sed fringilla consectetur</a>
          <a href="#" class="tm-text-blue-dark d-block mb-2">Mauris porta nisl quis</a>
          <a href="#" class="tm-text-blue-dark d-block mb-2">Quisque maximus quam nec</a>
          <a href="#" class="tm-text-blue-dark d-block">Class aptent taciti sociosqu ad</a>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 mb-4">
          <h4 class="mb-4 tm-font-300">Our Pages</h4>
          <a href="#" class="tm-text-blue-dark d-block mb-2">Nam dapibus imperdiet</a>
          <a href="#" class="tm-text-blue-dark d-block mb-2">Primis in faucibus orci</a>
          <a href="#" class="tm-text-blue-dark d-block mb-2">Sed interdum blandit dictum</a>
          <a href="#" class="tm-text-blue-dark d-block">Donec non blandit nisl</a>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
          <h4 class="mb-4 tm-font-300">Quick Links</h4>
          <a href="#" class="tm-text-blue-dark d-block mb-2">Nullam scelerisque mauris</a>
          <a href="#" class="tm-text-blue-dark d-block mb-2">Vivamus tristique enim non orci</a>
          <a href="#" class="tm-text-blue-dark d-block mb-2">Luctus et ultrices posuere</a>
          <a href="#" class="tm-text-blue-dark d-block">Cubilia Curae</a>
        </div>
      </div>
      <footer class="row">
        <div class="col-xl-12">
          <p class="text-center p-4">Copyright &copy; <span class="tm-current-year">2018</span> Your Company Name - Web Design:  <a href="http://tooplate.com" class="tm-text-gray">Tooplate</a></p>
        </div>
      </footer>
    </div> <!-- .container -->

  </div> <!-- .main --> 

  <!-- load JS -->
  <script src="js/jquery-3.2.1.slim.min.js"></script> <!-- https://jquery.com/ -->
  <script>
  

    /* DOM is ready
    ------------------------------------------------*/
    $(function () {

      if (renderPage) {
        $('body').addClass('loaded');
      }

      $('.tm-current-year').text(new Date().getFullYear());  // Update year in copyright
    });


  </script>
  <!-- jQuery, Popper.js y Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script> 
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> 

</body>
</html>