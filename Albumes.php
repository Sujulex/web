<?php session_start(); 
ini_set('display_errors', 1);
error_reporting(E_ALL);

include "config/Mysql.php";
include "modelos/Album.php";

$base = new Mysql();
$cx = $base->connect();
$album = new Album($cx);

// Validar sesión
if (!isset($_SESSION['id']) || !isset($_SESSION['rol_id'])) {
    die("Sesión no válida.");
    
}
// Paginación
$por_pagina = 30;
$pagina_actual = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
$inicio = ($pagina_actual - 1) * $por_pagina;

// Obtener todos los álbumes
$todos_albumes = $album->listar($_SESSION['id'], $_SESSION['rol_id']);
// Ordenar los álbumes alfabéticamente por título (sin importar mayúsculas)
usort($todos_albumes, function($a, $b) {
  return strcasecmp($a->titulo, $b->titulo);
});

$total_albumes = count($todos_albumes);
$total_paginas = ceil($total_albumes / $por_pagina);

// Cortar los álbumes para la página actual
$lista_albumes = array_slice($todos_albumes, $inicio, $por_pagina);

$lista_albumes = $album->listar($_SESSION['id'], $_SESSION['rol_id']);?>
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
        <img class="d-block w-100" src="img_blog_musica/Carrusel13.jpg" alt="Slide 1">
      </div>
      <!-- Segundo slide -->
      <div class="carousel-item">
        <img class="d-block w-100" src="img_blog_musica/Carrusel14.jpg" alt="Slide 2">
      </div>
      <!-- Tercer slide -->
      <div class="carousel-item">
        <img class="d-block w-100" src="img_blog_musica/Carrusel15.jpg" alt="Slide 3">
      </div>
      <!-- Cuarto slide -->
      <div class="carousel-item">
        <img class="d-block w-100" src="img_blog_musica/Carrusel16.jpg" alt="Slide 4">
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
    <h1 class="text-uppercase mb-3 tm-site-name">ÁLBUMES</h1>
    <p class="tm-site-description">Los mejores Albumes con las mejores canciones</p>
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
    color:rgb(79, 4, 185); /* Color dorado */
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
            <a href="index.php" class="nav-link tm-nav-link tm-text-white">Inicio</a>
          </li>
          <li class="nav-item">
            <a href="Artistas.php" class="nav-link tm-nav-link tm-text-white">Artistas</a>
          </li>
          <li class="nav-item">
            <a href="Canciones.php" class="nav-link tm-nav-link tm-text-white">Canciones</a>
          </li>
          <li class="nav-item">
            <a href="Albumes.php" class="nav-link tm-nav-link tm-text-white active">Álbumes</a>
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
      <h2 class="section-title">Gestión de Álbumes</h2>
      <p class="section-description">Aquí puedes añadir nuevos Álbumes o editar los existentes. ¡Haz crecer tu colección musical!</p>
      <div class="button-container">
        <a href="Admi/agregar_album.php" class="btn btn-action">Añadir Álbum </a>
        <!--<a href="editar_cancion.php" class="btn btn-action">Editar Álbum</a>-->
      </div>
    </div>
  </div>
</div>
<?php endif; ?>


<?php if (isset($_SESSION['mensaje'])): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert" id="alertaMensaje">
    <?= $_SESSION['mensaje'] ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
  </div>
  <?php unset($_SESSION['mensaje']); ?>
<?php endif; ?>





<div class="container mt-5">
  <div class="row">
    <?php foreach ($lista_albumes as $al): ?>
      <div class="col-12 col-md-6 col-lg-4 mb-4" id="album-<?= $al->id ?>">
        <div class="card album-card h-100 shadow-sm border-0">
          <div class="card-image-wrapper">
            <img src="img_blog_musica/Albumes/<?= htmlspecialchars($al->imagen) ?>" class="card-img-top" alt="<?= htmlspecialchars($al->titulo) ?>">
          </div>
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($al->titulo) ?></h5>
            <p class="card-text"><?= nl2br(htmlspecialchars($al->descripcion)) ?></p>
            <p class="card-artist mt-3 mb-2">
              <strong>Artista:</strong> 
              <a href="Artistas.php#artista-<?= $al->artista_id ?>" class="text-decoration-none text-primary">

                <?= htmlspecialchars($al->artista) ?>
              </a>
            </p>

            <?php if (isset($_SESSION['rol_id']) && $_SESSION['rol_id'] == 1): ?>
              <div class="text-center mt-3">
                <a href="Admi/editar_album.php?id=<?= $al->id ?>" class="btn btn-sm btn-outline-primary">
                  <i class="fas fa-edit"></i> Editar
                </a>
              </div>
            <?php endif; ?>
          </div>
          <div class="card-footer text-muted text-center">
            <small>Lanzamiento: <?= date('d M Y', strtotime($al->fecha_lanzamiento)) ?></small>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <!-- Paginación -->
<!-- Paginación -->
<div class="row mt-4">
  <div class="col text-center">
    <nav>
      <ul class="pagination justify-content-center">
        <!-- Botón Anterior -->
        <li class="page-item <?= $pagina_actual <= 1 ? 'disabled' : '' ?>">
          <a class="page-link" href="?pagina=<?= max(1, $pagina_actual - 1) ?>" tabindex="-1">Anterior</a>
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


<style>
  .pagination .page-item.active .page-link {
  background-color: #4A90E2;
  border-color: #4A90E2;
  color: white;
}

  .album-card {
    border-radius: 15px;
    overflow: hidden;
    background: linear-gradient(to bottom right, #ffffff, #f0f8ff);
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

  .card-image-wrapper img:hover {
    transform: scale(1.05);
  }

  .card-body {
    background: linear-gradient(to right, #e0f7fa, #fff3e0);
    padding: 20px;
    color: #333;
  }

  .card-title {
    font-family: 'Roboto', sans-serif;
    font-weight: bold;
    font-size: 1.5rem;
    color: #2c3e50;
    text-align: center;
  }

  .card-text {
    font-family: 'Open Sans', sans-serif;
    font-size: 1rem;
    color: #555;
    margin-top: 10px;
    text-align: justify;
  }

  .card-artist {
    font-family: 'Roboto', sans-serif;
    font-size: 1rem;
    color: #007bff;
  }

  .card-footer {
    background-color: #f8f9fa;
    border-top: none;
  }

  html {
  scroll-behavior: smooth;
}

</style>





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


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const alerta = document.getElementById('alertaMensaje');
    if (alerta) {
      // Cierra automáticamente en 5 segundos
      setTimeout(() => {
        const bsAlert = bootstrap.Alert.getOrCreateInstance(alerta);
        bsAlert.close();
      }, 5000);
    }
  });
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