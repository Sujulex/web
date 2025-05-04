<?php 
session_start();
include "../config/Mysql.php";
include "../modelos/Album.php";
include "../modelos/Artista.php";

$base = new Mysql();
$cx = $base->connect();
$album = new Album($cx);
$artista = new Artista($cx);

$titulo = "Agregar Canción";

if (isset($_POST["agregarCancion"])) {
  $titulo_cancion = $_POST["titulo"];
  $duracion = $_POST["duracion"];
  $album_id = $_POST["album_id"];
  $artista_id = $_POST["artista_id"];
  $archivo_audio = $_FILES["archivo_audio"]["name"];
  $imagen = $_FILES["imagen"]["name"];

  if (empty($titulo_cancion) || empty($duracion) || $album_id == 0 || $artista_id == 0 || empty($archivo_audio) || empty($imagen)) {
    $error = "Todos los campos deben estar completos.";
  } else {
    $carpeta_audio = "../audios/";
    $carpeta_imagenes = "../img_blog_musica/Canciones/";

    if (!file_exists($carpeta_audio)) mkdir($carpeta_audio, 0777, true);
    if (!file_exists($carpeta_imagenes)) mkdir($carpeta_imagenes, 0777, true);

    $audio_tmp = $_FILES["archivo_audio"]["tmp_name"];
    $imagen_tmp = $_FILES["imagen"]["tmp_name"];

    $ruta_audio = $carpeta_audio . uniqid() . "_" . basename($archivo_audio);
    $ruta_imagen = $carpeta_imagenes . uniqid() . "_" . basename($imagen);

    if (move_uploaded_file($audio_tmp, $ruta_audio) && move_uploaded_file($imagen_tmp, $ruta_imagen)) {
      $qry = "INSERT INTO canciones (titulo, imagen, duracion, archivo_audio, album_id, artista_id) 
              VALUES (:titulo, :imagen, :duracion, :archivo_audio, :album_id, :artista_id)";
      $st = $cx->prepare($qry);
      $st->bindParam(":titulo", $titulo_cancion);
      $st->bindParam(":imagen", basename($ruta_imagen));
      $st->bindParam(":duracion", $duracion);
      $st->bindParam(":archivo_audio", basename($ruta_audio));
      $st->bindParam(":album_id", $album_id);
      $st->bindParam(":artista_id", $artista_id);

      if ($st->execute()) {
        $mensaje = "Cancion agregada correctamente.";
        header("Location: ../Canciones.php?mensaje=" . urlencode($mensaje));
        exit();
      } else {
        $error = "No se pudo guardar la canción.";
      }
    } else {
      $error = "Error al subir archivos.";
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

.navbar {
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
    background-color: rgba(0, 0, 0, 0.7);
    border-bottom: 2px solid white;
}

.cancion-container {
  margin-top: 80px; /* espacio extra */
  
}


    .navbar {
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
    background-color: rgba(0, 0, 0, 0.7);
    border-bottom: 2px solid white;
}

    .cancion-container {
      background-color: #ffffffee;
      border: 4px solid #a84ed0;
      border-radius: 20px;
      padding: 40px 50px;
      width: 100%;
      max-width: 700px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .cancion-container h2 {
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
  <div class="cancion-container">
    <?php if (isset($error)): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <h2><?= $titulo ?></h2>
    <form method="POST" action="" enctype="multipart/form-data">
      <label for="titulo">Título de la canción:</label>
      <input type="text" class="form-control" name="titulo" required>

      <label for="duracion" class="form-label mb-0" style="min-width: 100px;">Duración:</label>
      <input type="text" class="form-control" name="duracion" id="duracion"
       pattern="^([0-5]?[0-9]):([0-5][0-9])$"
       placeholder="Ej: 03:45 (MM:SS)" required>

      <label for="album_id">Álbum:</label>
      <select name="album_id" class="form-select" required>
        <option value="0">Selecciona un álbum</option>
        <?php foreach ($album->listar($_SESSION['id'], $_SESSION['rol_id']) as $al): ?>
          <option value="<?= $al->id ?>"><?= $al->titulo ?></option>
        <?php endforeach; ?>
      </select>

      <label for="artista_id">Artista:</label>
      <select name="artista_id" class="form-select" required>
        <option value="0">Selecciona un artista</option>
        <?php foreach ($artista->listar($_SESSION['id'], $_SESSION['rol_id']) as $a): ?>
          <option value="<?= $a->id ?>"><?= $a->nombre ?></option>
        <?php endforeach; ?>
      </select>

      <div class="mb-3 d-flex align-items-center gap-3">
        <label for="archivo_audio" class="form-label mb-0" style="min-width: 150px;">Archivo de audio:</label>
        <input type="file" class="form-control" name="archivo_audio" accept="audio/*" required style="flex: 1;">
      </div>

      <div class="mb-3 d-flex align-items-center gap-3">
        <label for="imagen" class="form-label mb-0" style="min-width: 100px;">Imagen:</label>
        <input type="file" class="form-control" name="imagen" id="imagen" accept="image/*" style="flex: 1; max-width: 300px;">
        <img id="preview" src="#" alt="Vista previa" style="display: none; width: 100px; height: auto; border-radius: 10px; object-fit: cover; border: 2px solid #ccc;">
      </div>

      <button type="submit" name="agregarCancion" class="btn-agregar">Agregar Canción</button>
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

