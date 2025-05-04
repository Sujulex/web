<?php
session_start();
include "config/Mysql.php";
include "modelos/Artista.php";

$base = new Mysql();
$cx = $base->connect();
$artista = new Artista($cx);

// Variables de paginación
$por_pagina = 30;
$pagina_actual = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
$inicio = ($pagina_actual - 1) * $por_pagina;

// Obtener todos y paginar
$todos = $artista->listar($_SESSION['id'], $_SESSION['rol_id']);
usort($todos, function($a, $b) {
  return strcasecmp($a->nombre, $b->nombre);
});
$total_artistas = count($todos);
$total_paginas = ceil($total_artistas / $por_pagina);
$lista_artistas = array_slice($todos, $inicio, $por_pagina);

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
        <img class="d-block w-100" src="img_blog_musica/Carrusel5.jpg" alt="Slide 1">
      </div>
      <!-- Segundo slide -->
      <div class="carousel-item">
        <img class="d-block w-100" src="img_blog_musica/Carrusel6.jpg" alt="Slide 2">
      </div>
      <!-- Tercer slide -->
      <div class="carousel-item">
        <img class="d-block w-100" src="img_blog_musica/Carrusel7.jpg" alt="Slide 3">
      </div>
      <!-- Cuarto slide -->
      <div class="carousel-item">
        <img class="d-block w-100" src="img_blog_musica/Carrusel8.jpg" alt="Slide 4">
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
    <h1 class="text-uppercase mb-3 tm-site-name">ARTISTAS</h1>
    <p class="tm-site-description">Busca a tus Artistas favoritos</p>
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
    color:rgb(0, 153, 15); /* Color dorado */
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
        <a class="dropdown-item text-white" href="Admi/usuarios.php">usuarios</a>
      </div>
    </li>
  <?php endif; ?>
</ul>




        <!-- Menú Derecho -->
        <ul class="navbar-nav ml-auto align-items-center pr-4">
          <!-- Menú normal -->
          <li class="nav-item active">
            <a href="index.php" class="nav-link tm-nav-link tm-text-white ">Inicio</a>
          </li>
          <li class="nav-item">
            <a href="Artistas.php" class="nav-link tm-nav-link tm-text-white active">Artistas</a>
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



        </ul>
      </nav>
    </div>
  </div>
</div>




<?php if (isset($_SESSION['rol_id']) && $_SESSION['rol_id'] == 1): ?>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-lg-8 text-center">
      <h2 class="section-title">Gestión de Artistas</h2>
      <p class="section-description">Aquí puedes añadir nuevos artistas o editar los existentes. ¡Haz crecer tu colección musical!</p>
      <div class="button-container">
        <a href="Admi/agregar_artista.php" class="btn btn-action">Añadir Artista</a>
       <!-- <a href="Admi/editar_artista.php" class="btn btn-action">Editar Artista</a> -->
      </div>
    </div>
  </div>
</div>
<?php endif; ?>


<?php if (!empty($mensaje)): ?>
  <div class="container mt-3">
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="mensajeExito">
      <?= htmlspecialchars($mensaje) ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  </div>
<?php endif; ?>




<div class="container mt-5">
  <div class="row justify-content-center">
    <?php foreach ($lista_artistas as $a): ?>
      <div class="col-12 col-md-6 col-lg-4 mb-4" id="artista-<?= $a->id ?>">
        <div class="card artist-card h-100">
          <div class="card-image-wrapper">
            <img src="img_blog_musica/Artistas/<?= htmlspecialchars($a->imagen) ?>" class="card-img-top" alt="<?= htmlspecialchars($a->nombre) ?>">
          </div>
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($a->nombre) ?></h5>
            <p class="card-text"><?= nl2br(htmlspecialchars($a->descripcion)) ?></p>
          </div>
          <?php if (isset($_SESSION['rol_id']) && $_SESSION['rol_id'] == 1): ?>
            <div class="card-footer bg-white border-0 text-center mt-auto">
              <a href="Admi/editar_artista.php?id=<?= $a->id ?>" class="btn btn-sm btn-primary">
                <i class="fas fa-edit"></i> Editar
              </a>
            </div>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

 
  <div class="row mt-4">
    <div class="col text-center">
      <nav>
        <ul class="pagination justify-content-center">
          <!-- Botón Anterior -->
          <li class="page-item <?= $pagina_actual <= 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="?pagina=<?= max(1, $pagina_actual - 1) ?>">Anterior</a>
          </li>

          <!-- Números de página -->
          <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
            <li class="page-item <?= $i == $pagina_actual ? 'active' : '' ?>">
              <a class="page-link" href="?pagina=<?= $i ?>"><?= $i ?></a>
            </li>
          <?php endfor; ?>

          <!-- Botón Siguiente -->
          <li class="page-item <?= $pagina_actual >= $total_paginas ? 'disabled' : '' ?>">
            <a class="page-link" href="?pagina=<?= min($total_paginas, $pagina_actual + 1) ?>">Siguiente</a>
          </li>
        </ul>
      </nav>
    </div>
  </div>



</div>


  
</div>

<style>

.pagination {
  justify-content: center;
}

.pagination .page-item .page-link {
  color: #4A90E2;
  border: 1px solid #4A90E2;
  margin: 0 3px;
  transition: background-color 0.3s ease;
}

.pagination .page-item.active .page-link {
  background-color: #4A90E2;
  border-color: #4A90E2;
  color: white;
}

.pagination .page-item.disabled .page-link {
  color: #ccc;
  pointer-events: none;
  background-color: #f8f9fa;
  border-color: #dee2e6;
}


  .artist-card {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease;
  }

  .artist-card:hover {
    transform: scale(1.02);
  }

  .card-image-wrapper img {
    height: 300px;
    object-fit: cover;
    width: 100%;
  }

  .artist-card .card-body {
    background: linear-gradient(to right, #a8edea, #fed6e3); /* degradado bonito */
    padding: 20px;
    color: #333;
  }

  .artist-card .card-title {
    font-family: 'Roboto', sans-serif;
    font-weight: 700;
    font-size: 1.5rem;
    color: #2c3e50;
  }

  .artist-card .card-text {
    font-family: 'Open Sans', sans-serif;
    font-size: 1rem;
    color: #4a4a4a;
    margin-top: 10px;
    white-space: pre-line;
  }
</le>

<style>
  .artist-card {
    border: none;
    border-radius: 20px;
    overflow: hidden;
    background: linear-gradient(145deg, #fdfbfb, #ebedee);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .artist-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
  }

  .card-image-wrapper {
    overflow: hidden;
    height: 250px;
  }

  .card-image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
  }

  .card-image-wrapper img:hover {
    transform: scale(1.05);
  }

  .card-body {
    padding: 20px;
    background: rgba(255, 255, 255, 0.9);
  }

  .card-title {
    font-family: 'Roboto', sans-serif;
    font-size: 1.5rem;
    font-weight: 700;
    color:rgb(27, 96, 164);
    margin-bottom: 15px;
    text-align: center;
    text-transform: uppercase;
  }

  .card-text {
    font-family: 'Open Sans', sans-serif;
    font-size: 1rem;
    color: #555;
    text-align: justify;
  }

  html {
  scroll-behavior: smooth;
}

</style>





<!--
      <div class="container text-center tm-welcome-container">
        <div class="tm-welcome">
          <i class="fas tm-fa-big fa-music tm-fa-mb-big"></i>
          <h1 class="text-uppercase mb-3 tm-site-name">Insertion</h1>
          <p class="tm-site-description">New HTML Website Template</p>
        </div>
      </div>

    </div>

    <div class="container">
      <div class="tm-search-form-container">
        <form action="index.html" method="GET" class="form-inline tm-search-form">
          <div class="text-uppercase tm-new-release">New Release</div>
          <div class="form-group tm-search-box">
            <input type="text" name="keyword" class="form-control tm-search-input" placeholder="Type your keyword ...">
            <input type="submit" value="Search" class="form-control tm-search-submit">
          </div>
          <div class="form-group tm-advanced-box">
            <a href="#" class="tm-text-white">Go Advanced ...</a>
          </div>
        </form>
      </div>

      <div class="row tm-about-row tm-mt-big tm-mb-medium">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 tm-about-col-left">
          <div class="tm-v-center tm-bg-gray h-100 tm-about-text">
            <h2 class="tm-text-brown mb-4 tm-about-h2">Lorem ipsum dolor sit amet</h2>
            <p class="tm-about-description mb-0">Donec eu placerat sapien. Ut volutpat metus ipsum, a porttitor est consectetur quis. Pellentesque sit amet tristique odio, sed vulputate purus. Aliquam mattis suscipit orci, nec vehicula orci gravida sit amet. Morbi vel tortor et mauris sodales pretium.</p>
          </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
          <div class="tm-about-img"></div>
        </div>
      </div>

      <div class="row tm-about-row tm-mb-medium">
        <div class="tm-tab-links-container">

          <ul class="nav nav-tabs" id="tmTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link tm-bg-gray tm-media-v-center tm-tab-link active" id="home-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="home" aria-selected="true">
                <i class="fas fa-2x fa-music pr-4"></i>
                <p class="media-body mb-0 tm-media-link">Proin vitae ligula</p>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link tm-bg-gray tm-media-v-center tm-tab-link" id="profile-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="profile" aria-selected="false">
                <i class="fab fa-2x fa-accusoft pr-4"></i>
                <p class="media-body mb-0 tm-media-link">Nunc nec luctus</p>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link tm-bg-gray tm-media-v-center tm-tab-link" id="contact-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="contact" aria-selected="false">
                <i class="fab fa-2x fa-amazon-pay pr-4"></i>
                <p class="media-body mb-0 tm-media-link">Etiam vel ligula</p>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link tm-bg-gray tm-media-v-center tm-tab-link" id="contact-tab" data-toggle="tab" href="#tab4" role="tab" aria-controls="contact" aria-selected="false">
                <i class="fas fa-2x fa-headphones pr-4"></i>
                <p class="media-body mb-0 tm-media-link">Sed id magna</p>
              </a>
            </li>
          </ul>

        </div>

        <div class="tm-tab-content-container">
          <div class="tab-content h-100 tm-bg-gray" id="myTabContent">
            <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
              <div class="media tm-media-2">
                <i class="fas fa-5x fa-music mb-3 tm-text-pink-dark tm-media-2-icon"></i>
                <div class="media-body tm-media-body-2">
                  <h2 class="mb-4 tm-text-pink-dark tm-media-2-header">Quisque pharetra tellus eu mi aliquet</h2>
                  <p class="mb-4">Phasellus efficitur, ante et bibendum accumsan, nisi tellus fermentum eros, eget tincidunt enim orci at arcu. Etiam vel ligula non neque pharetra scelerisque mollis ac arcu.</p>
                  <p class="mb-4">In luctus eu turpis sed sodales. Suspendisse nisi ante, dapibus id purus at, tristique ullamcorper dolor. Nullam tempus quam id odio tempus bibendum. Nullam vulputate, justo fermentum interdum fermentum, diam elit iaculis lorem, sed puvina.</p>
                  <a href="#" class="btn btn-secondary">Read More</a>
                </div>
              </div>
            </div>

            <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
              <div class="media tm-media-2">
                <i class="fab fa-5x fa-accusoft mb-3 tm-text-pink-dark tm-media-2-icon"></i>
                <div class="media-body tm-media-body-2">
                  <h2 class="mb-4 tm-text-pink-dark tm-media-2-header">Nunc nec luctus eu mi aliquet</h2>
                  <p class="mb-4">Phasellus efficitur, ante et bibendum accumsan, nisi tellus fermentum eros, eget tincidunt enim orci at arcu. Etiam vel ligula non neque pharetra scelerisque mollis ac arcu.</p>
                  <p class="mb-4">In luctus eu turpis sed sodales. Suspendisse nisi ante, dapibus id purus at, tristique ullamcorper dolor. Nullam tempus quam id odio tempus bibendum. Nullam vulputate, justo fermentum interdum fermentum, diam elit iaculis lorem, sed puvina.</p>
                  <a href="#" class="btn btn-secondary">Read More</a>
                </div>
              </div>
            </div>

            <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
              <div class="media tm-media-2">
                <i class="fab fa-5x fa-amazon-pay mb-3 tm-text-pink-dark tm-media-2-icon"></i>
                <div class="media-body tm-media-body-2">
                  <h2 class="mb-4 tm-text-pink-dark tm-media-2-header">Etiam vel ligula eu mi aliquet</h2>
                  <p class="mb-4">Phasellus efficitur, ante et bibendum accumsan, nisi tellus fermentum eros, eget tincidunt enim orci at arcu. Etiam vel ligula non neque pharetra scelerisque mollis ac arcu.</p>
                  <p class="mb-4">In luctus eu turpis sed sodales. Suspendisse nisi ante, dapibus id purus at, tristique ullamcorper dolor. Nullam tempus quam id odio tempus bibendum. Nullam vulputate, justo fermentum interdum fermentum, diam elit iaculis lorem, sed puvina.</p>
                  <a href="#" class="btn btn-secondary">Read More</a>
                </div>
              </div>
            </div>

            <div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab4-tab">
              <div class="media tm-media-2">
                <i class="fas fa-5x fa-headphones mb-3 tm-text-pink-dark tm-media-2-icon"></i>
                <div class="media-body tm-media-body-2">
                  <h2 class="mb-4 tm-text-pink-dark tm-media-2-header">Sed id magna eu mi aliquet</h2>
                  <p class="mb-4">Phasellus efficitur, ante et bibendum accumsan, nisi tellus fermentum eros, eget tincidunt enim orci at arcu. Etiam vel ligula non neque pharetra scelerisque mollis ac arcu.</p>
                  <p class="mb-4">In luctus eu turpis sed sodales. Suspendisse nisi ante, dapibus id purus at, tristique ullamcorper dolor. Nullam tempus quam id odio tempus bibendum. Nullam vulputate, justo fermentum interdum fermentum, diam elit iaculis lorem, sed puvina.</p>
                  <a href="#" class="btn btn-secondary">Read More</a>
                </div>
              </div>
            </div>

          </div>

        </div>
      </div>

      <div class="row tm-about-row tm-mb-medium">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
          <div class="embed-responsive embed-responsive-21by9">
            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/EreZNkWzBAw?rel=0" allowfullscreen></iframe>
          </div>
        </div>
      </div>

      <!-- Bottom links -->
      <!--<div class="row tm-about-row tm-mb-medium">
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
      <footer class="row tm-about-row">
        <div class="col-xl-12">
          <p class="text-center p-4">Copyright &copy; <span class="tm-current-year">2018</span> Your Company Name - Web Design:  <a href="http://tooplate.com" class="tm-text-gray">Tooplate</a></p>
        </div>
      </footer>
    </div> <!-- .container -->

  </div> <!-- .main -->

  <!-- load JS -->
  <script src="js/jquery-3.2.1.slim.min.js"></script> <!-- https://jquery.com/ -->
  <script src="js/bootstrap.min.js"></script>         <!-- https://getbootstrap.com/ -->
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


<script>
  setTimeout(function () {
  const alertEl = document.getElementById('mensajeExito');
  if (alertEl) {
    const alert = new bootstrap.Alert(alertEl);
    alert.close();
  }
}, 5000);

</script>

<script>
  // Si hay un hash en la URL (por ejemplo #artista-5), hacer scroll suave
  document.addEventListener("DOMContentLoaded", function () {
    const hash = window.location.hash;
    if (hash) {
      const target = document.querySelector(hash);
      if (target) {
        setTimeout(() => {
          target.scrollIntoView({ behavior: "smooth", block: "start" });
        }, 300); // Espera un poco a que se renderice
      }
    }
  });
</script>

</body>
</html>