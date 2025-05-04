<?php 
  session_start();
  include "../config/Mysql.php";
  include "../modelos/Album.php";
  include "../modelos/Artista.php";

  $base = new Mysql();
  $cx = $base->connect();
  $album = new Album($cx);
  $artista = new Artista($cx);

  $titulo = "Agregar Álbum";

  if (isset($_POST["gestionAlbum"])) {
    $titulo_album = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];
    $fecha = $_POST["fecha_lanzamiento"];
    $artista_id = $_POST["artista_id"];

    if (empty($titulo_album) || empty($descripcion) || empty($fecha) || $artista_id == 0) {
      $error = "Todos los campos deben tener información válida.";
    } else {
      if ($_FILES['imagen']['error'] > 0) {
        $error = "Error al subir la imagen.";
      } else {
        $imagen = $_FILES['imagen']['name'];
        $imgArr = explode(".", $imagen);
        $rand = rand(1000, 9999);
        $nuevoNombreImagen = $imgArr[0] . $rand . "." . $imgArr[1];
        $rutaFinal = "../img_blog_musica/Albumes/" . $nuevoNombreImagen;

        if (!file_exists("../img_blog_musica/Albumes/")) {
          mkdir("../img_blog_musica/Albumes/", 0777, true);
        }

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaFinal)) {
          if ($album->agregar($titulo_album, $descripcion, $nuevoNombreImagen, $fecha, $artista_id)) {
            $mensaje = "Álbum agregado correctamente.";
            header("Location: ../Albumes.php?mensaje=" . urlencode($mensaje));
            exit();
          } else {
            $error = "No se pudo guardar el álbum.";
          }
        } else {
          $error = "Error al mover la imagen.";
        }
      }
    }
  }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?= $titulo ?></title>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/tooplate-style.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,700&display=swap">
  <style>
    body {
      min-height: 100vh;
      background: linear-gradient(-45deg, #fbc2eb, #a6c1ee, #fffca8, #a8ffd4);
      background-size: 400% 400%;
      animation: gradientBackground 15s ease infinite;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px;
    }

    @keyframes gradientBackground {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .album-container {
  margin-top: 80px; /* espacio extra */
}


    .navbar {
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
    background-color: rgba(0, 0, 0, 0.7);
    border-bottom: 2px solid white;
}

    .album-container {
      background-color: #ffffffee;
      border: 4px solid #a84ed0;
      border-radius: 20px;
      padding: 40px 50px;
      width: 100%;
      max-width: 700px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .album-container h2 {
      font-family: 'Roboto', sans-serif;
      font-size: 2.5rem;
      color: #8e44ad;
      text-align: center;
      margin-bottom: 30px;
      font-weight: bold;
      text-transform: uppercase;
    }

    .form-control, .form-select {
      background-color: #f7f7f7;
      border: 2px solid #a84ed0;
      border-radius: 10px;
      font-size: 1rem;
      padding: 12px 20px;
      margin-bottom: 20px;
      transition: all 0.3s ease;
    }

    .btn-agregar {
      background-color: #a84ed0;
      color: white;
      font-weight: bold;
      width: 100%;
      padding: 12px;
      border-radius: 10px;
      border: none;
    }

    .btn-agregar:hover {
      background-color: #7b2cbf;
    }

    .alert {
      font-size: 1rem;
      font-weight: bold;
    }
  </style>

</head>

<body>
<div class="container-fluid tm-navbar-container">
  <div class="row">
    <div class="col-xl-12">
      <nav class="navbar navbar-expand-sm">
        <!-- Menú izquierdo -->
        <ul class="navbar-nav align-items-center">
        <?php if (isset($_SESSION['auth']) && $_SESSION['auth'] && $_SESSION['rol_id'] == 1): ?>  
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle tm-nav-link tm-text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="border: 1px solid white; padding: 5px 10px; border-radius: 5px;">
              Administración
            </a>
            <div class="dropdown-menu bg-dark border-0" aria-labelledby="navbarDropdown">
              <a class="dropdown-item text-white" href="usuarios.php">Usuarios</a>
            </div>
          </li>
        <?php endif; ?>
        </ul>

        <!-- Menú derecho -->
        <ul class="navbar-nav ml-auto align-items-center pr-4">
          <li class="nav-item active">
            <a href="../index.php" class="nav-link tm-nav-link tm-text-white active">Inicio</a>
          </li>
          <li class="nav-item">
            <a href="../Artistas.php" class="nav-link tm-nav-link tm-text-white">Artistas</a>
          </li>
          <li class="nav-item">
            <a href="../Canciones.php" class="nav-link tm-nav-link tm-text-white">Canciones</a>
          </li>
          <li class="nav-item">
            <a href="../Albumes.php" class="nav-link tm-nav-link tm-text-white">Álbumes</a>
          </li>

          <?php if (isset($_SESSION['auth']) && $_SESSION['auth']): ?>
            <li class="nav-item d-flex align-items-center">
              <span class="nav-link tm-nav-link tm-text-white"><?= htmlspecialchars($_SESSION['nombre']) ?></span>
              <li>
                <a href="../salir.php" class="nav-link tm-nav-linkIS tm-text-white" style="border: 1px solid white; padding: 5px 10px; border-radius: 5px; margin-left: 10px;">Salir</a>
              </li>
            </li>
          <?php else: ?>
            <li>
              <a href="../login.php" class="nav-link tm-nav-linkIS tm-text-white" style="border: 1px solid white; padding: 5px 10px; border-radius: 5px;">Iniciar sesión</a>
            </li>
          <?php endif; ?>
        </ul>
      </nav>
    </div>
  </div>
</div>

<div class="mt-5"></div>

  <div class="album-container">
    <?php if (isset($error)): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <h2><?= $titulo ?></h2>
    <form method="POST" action="" enctype="multipart/form-data">
      <label for="titulo">Título:</label>
      <input type="text" class="form-control" name="titulo" id="titulo" required>

      <label for="descripcion">Descripción:</label>
      <textarea class="form-control" name="descripcion" rows="4" required></textarea>

      <label for="fecha_lanzamiento">Fecha de lanzamiento:</label>
      <input type="datetime-local" class="form-control" name="fecha_lanzamiento" required>

      <label for="artista_id">Artista:</label>
      <select name="artista_id" class="form-select" required>
        <option value="0">Selecciona un artista</option>
        <?php foreach ($artista->listar($_SESSION['id'], $_SESSION['rol_id']) as $art): ?>
          <option value="<?= $art->id ?>"><?= $art->nombre ?></option>
        <?php endforeach; ?>
      </select>

      <div class="mb-3">
      <div class="mb-3 d-flex align-items-center gap-3">
  <label for="imagen" class="form-label mb-0" style="min-width: 80px;">Imagen:</label>
  <input type="file" class="form-control" name="imagen" id="imagen" style="max-width: 300px;">
  <img id="preview" src="#" alt="Vista previa" style="display: none; width: 120px; height: auto; border-radius: 10px; object-fit: cover; border: 2px solid #ccc;">
</div>



      <button type="submit" name="gestionAlbum" class="btn-agregar">Agregar Álbum</button>
    </form>
  </div>
  <script>
  document.getElementById("imagen").addEventListener("change", function(event) {
    const [file] = event.target.files;
    if (file) {
      const preview = document.getElementById("preview");
      preview.src = URL.createObjectURL(file);
      preview.style.display = "block";
    }
  });
</script>

</body>
</html>
