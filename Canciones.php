<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

include "config/Mysql.php";
include "modelos/Cancion.php";

$base = new Mysql();
$cx = $base->connect();
$cancion = new Cancion($cx);

// Validar sesión
if (!isset($_SESSION['id']) || !isset($_SESSION['rol_id'])) {
    die("Sesión no válida.");
}

$lista_canciones = $cancion->listar($_SESSION['id'], $_SESSION['rol_id']);

$mensaje = "";
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    unset($_SESSION['mensaje']);


}
$por_pagina = 30;
$pagina_actual = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
$inicio = ($pagina_actual - 1) * $por_pagina;

$todas_canciones = $cancion->listar($_SESSION['id'], $_SESSION['rol_id']);
usort($todas_canciones, function($a, $b) {
  return strcasecmp($a->titulo, $b->titulo);
});

$total_canciones = count($todas_canciones);
$total_paginas = ceil($total_canciones / $por_pagina);

// Canciones solo para esta página
$lista_canciones = array_slice($todas_canciones, $inicio, $por_pagina);

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MUSIC BLOG</title>

  <!-- CSS -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/fontawesome-all.min.css">
  <link rel="stylesheet" href="css/tooplate-style.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">

  <script>
    var renderPage = true;
    if (navigator.userAgent.indexOf('MSIE') !== -1 || navigator.appVersion.indexOf('Trident/') > 0) {
      alert("Please view this in a modern browser such as Chrome or Microsoft Edge.");
      renderPage = false;
    }
  </script>
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
          <div class="carousel-item active">
            <img class="d-block w-100" src="img_blog_musica/Carrusel9.jpeg" alt="Slide 1">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="img_blog_musica/Carrusel10.jpg" alt="Slide 2">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="img_blog_musica/Carrusel11.jpg" alt="Slide 3">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="img_blog_musica/Carrusel12.jpg" alt="Slide 4">
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
      <div class="carousel-caption d-none d-md-block">
        <i class="fas tm-fa-big fa-music tm-fa-mb-big"></i>
        <h1 class="text-uppercase mb-3 tm-site-name">CANCIONES</h1>
        <p class="tm-site-description">Encuentra tus canciones favoritas</p>
      </div>
    </div>

    <!-- Estilos para slider -->
    <style>
      .carousel-item img {
        height: 100vh;
        object-fit: cover;
        width: 100%;
      }

      .carousel-caption {
        background-color: rgba(0, 0, 0, 0.4);
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

      .carousel-caption h1 {
        font-family: 'Roboto', sans-serif;
        font-weight: 900;
        font-size: 7rem;
        color: rgb(209, 24, 24);
        -webkit-text-stroke: 2px black;
        letter-spacing: 3px;
        margin-bottom: 20px;
        text-transform: uppercase;
      }

      .carousel-caption p {
        font-family: 'Roboto', sans-serif;
        font-weight: 700;
        font-size: 2.5rem;
        color: white;
        -webkit-text-stroke: 1px black;
        letter-spacing: 2px;
      }

      .carousel-control-prev,
      .carousel-control-next {
        z-index: 20;
      }

      .carousel,
      .carousel-inner {
        background: none !important;
      }

      .slider-container {
        margin-bottom: 100px;
      }

      .tm-main {
        padding-top: 0;
        margin-top: 0 !important;
      }

      html {
  scroll-behavior: smooth;
}
    </style>

    <!-- Navegación -->
    <div class="container-fluid tm-navbar-container">
      <div class="row">
        <div class="col-xl-12">
          <nav class="navbar navbar-expand-sm" style="font-family: 'Open Sans', Helvetica, Arial, sans-serif; position: relative; z-index: 50;">
            <ul class="navbar-nav align-items-center">
              <?php if (isset($_SESSION['auth']) && $_SESSION['auth'] && isset($_SESSION['rol_id']) && $_SESSION['rol_id'] == 1): ?>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle tm-nav-link tm-text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border: 1px solid white; padding: 5px 10px; border-radius: 5px;">
                    Administración
                  </a>
                  <div class="dropdown-menu dropdown-menu-right bg-dark border-0" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item text-white" href="Admi/usuarios.php">Usuarios</a>
                  </div>
                </li>
              <?php endif; ?>
            </ul>
            <ul class="navbar-nav ml-auto align-items-center pr-4">
              <li class="nav-item"><a href="index.php" class="nav-link tm-nav-link tm-text-white">Inicio</a></li>
              <li class="nav-item"><a href="Artistas.php" class="nav-link tm-nav-link tm-text-white">Artistas</a></li>
              <li class="nav-item"><a href="Canciones.php" class="nav-link tm-nav-link tm-text-white active">Canciones</a></li>
              <li class="nav-item"><a href="Albumes.php" class="nav-link tm-nav-link tm-text-white">Álbumes</a></li>
              <?php if (isset($_SESSION['auth']) && $_SESSION['auth']): ?>
                <li class="nav-item d-flex align-items-center">
                  <span class="nav-link tm-nav-link tm-text-white d-flex align-items-center">
                    <i class="fas fa-user-circle mr-2"></i> <?= htmlspecialchars($_SESSION['nombre']) ?>
                  </span>
                </li>
                <li>
                  <a href="salir.php" class="nav-link tm-nav-linkIS tm-text-white" style="border: 1px solid white; padding: 5px 10px; border-radius: 5px; margin-left: 10px;">
                    Salir
                  </a>
                </li>
              <?php else: ?>
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

    <!-- Botón agregar canción -->
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
          <h2 class="section-title">Gestión de Canciones</h2>
          <p class="section-description">Aquí puedes añadir nuevas Canciones o editar las existentes.</p>
          <div class="button-container">
            <a href="Admi/agregar_cancion.php" class="btn btn-action">Añadir Canción</a>
          </div>
        </div>
      </div>
    </div>

    <?php if (!empty($mensaje)): ?>
  <div class="container mt-3">
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="mensajeExito">
      <?= htmlspecialchars($mensaje) ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  </div>
<?php endif; ?>




    

    <!-- Tarjetas -->
    <div class="container mt-5">
      <div class="row">
        <?php foreach ($lista_canciones as $c): ?>
          <div class="col-12 col-md-6 col-lg-4 mb-4" id="cancion-<?= $c->id ?>">
            <div class="card album-card h-100 shadow-sm border-0">
              <div class="card-image-wrapper">
                <img src="img_blog_musica/Canciones/<?= htmlspecialchars($c->imagen) ?>" class="card-img-top" alt="<?= htmlspecialchars($c->titulo) ?>">
              </div>
              <div class="card-body">
                <h5 class="card-title text-center"><?= htmlspecialchars($c->titulo) ?></h5>
                <p class="card-text">
  <strong>Álbum:</strong>
  <a href="Albumes.php#album-<?= $c->album_id ?>"><?= htmlspecialchars($c->album) ?></a>
</p>

<p class="card-text">
  <strong>Artista:</strong>
  <a href="Artistas.php#artista-<?= $c->artista_id ?>"><?= htmlspecialchars($c->artista) ?></a>
</p>


                <p class="card-text"><strong>Duración:</strong> <?= htmlspecialchars($c->duracion) ?></p>
               <!-- <p class="card-text"><strong>Álbum:</strong> <?= htmlspecialchars($c->album) ?></p>
                <p class="card-text"><strong>Artista:</strong> <?= htmlspecialchars($c->artista) ?></p> -->
                <audio controls style="width: 100%;">
                  <source src="audios/<?= htmlspecialchars($c->archivo_audio) ?>" type="audio/mpeg">
                  Tu navegador no soporta audio HTML5.
                </audio>
                <?php if ($_SESSION['rol_id'] == 1): ?>
                  <div class="text-center mt-3">
                    <a href="Admi/editar_cancion.php?id=<?= $c->id ?>" class="btn btn-sm btn-outline-primary">
                      <i class="fas fa-edit"></i> Editar
                    </a>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <?php if ($total_paginas > 1 || $total_canciones > 0): ?>
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
<?php endif; ?>

    </div>

    <!-- Estilos para tarjetas -->
    <style>


.pagination .page-link {
  color: ##4A90E2;
  border: 1px solid #4A90E2;
}
.pagination .page-item.active .page-link {
  background-color: #4A90E2;
  border-color: #4A90E2;
  color: white;
}

      .album-card {
        border-radius: 15px;
        overflow: hidden;
        background: linear-gradient(to bottom right, #ffffff, #fef3e2);
        transition: transform 0.3s ease;
      }

      .album-card:hover {
        transform: scale(1.03);
        box-shadow: 0 12px 20px rgba(0, 0, 0, 0.2);
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

      .card-body {
        background: linear-gradient(to right,rgb(236, 199, 199),rgb(229, 189, 250));
        padding: 20px;
        color: #333;
      }

      .card-title {
        font-family: 'Roboto', sans-serif;
        font-weight: bold;
        font-size: 1.5rem;
        color: #2c3e50;
      }

      .card-text {
        font-family: 'Open Sans', sans-serif;
        font-size: 1rem;
        margin-top: 10px;
        color: #555;
      }
    </style>

  </div>

  <!-- JS -->
  <script src="js/jquery-3.2.1.slim.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script>
    $(function () {
      if (renderPage) $('body').addClass('loaded');
    });
  </script>


<script>
  setTimeout(function () {
    const alert = document.getElementById('mensajeExito');
    if (alert) {
      // Usa jQuery para cerrar la alerta con Bootstrap 4
      $(alert).alert('close');
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


