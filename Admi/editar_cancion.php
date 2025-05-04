<?php
session_start();
include "../config/Mysql.php";
include "../modelos/Album.php";
include "../modelos/Artista.php";
include "../modelos/Cancion.php";

$base = new Mysql();
$cx = $base->connect();
$album = new Album($cx);
$artista = new Artista($cx);
$cancion = new Cancion($cx);

if (!isset($_GET['id'])) {
    header("Location: ../Canciones.php");
    exit();
}

$id = $_GET['id'];
$c = $cancion->getCancion($id);
$lista_albumes = $album->listar($_SESSION['id'], $_SESSION['rol_id']);
$lista_artistas = $artista->listar($_SESSION['id'], $_SESSION['rol_id']);

if (isset($_POST['editarCancion'])) {
    $titulo = $_POST['titulo'];
    $duracion = $_POST['duracion'];
    $album_id = $_POST['album_id'];
    $artista_id = $_POST['artista_id'];
    $imagen = $imagen = $c->imagen;  // conserva la imagen original por defecto
    $audio = $c->archivo_audio;

    if (empty($titulo) || empty($duracion) || $album_id == 0 || $artista_id == 0) {
        $error = "Todos los campos son obligatorios.";
    } else {
        if ($_FILES['imagen']['error'] == 0) {
            $img = $_FILES['imagen']['name'];
            $ext = pathinfo($img, PATHINFO_EXTENSION);
            $newImg = uniqid() . "." . $ext;
            $imgPath = "../img_blog_musica/Canciones/" . $newImg;
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $imgPath)) {
                $imagen = $newImg;
            } else {
                $error = "Error al guardar la imagen.";
            }
        }

        if ($_FILES['archivo_audio']['error'] == 0) {
            $aud = $_FILES['archivo_audio']['name'];
            $ext = pathinfo($aud, PATHINFO_EXTENSION);
            $newAud = uniqid() . "." . $ext;
            $audPath = "../audios/" . $newAud;
            if (move_uploaded_file($_FILES['archivo_audio']['tmp_name'], $audPath)) {
                $audio = $newAud;
            } else {
                $error = "Error al guardar el audio.";
            }
        }

        if (!isset($error)) {
            $ok = $cancion->editar($id, $titulo, $imagen, $duracion, $audio, $album_id, $artista_id);
            if ($ok) {
                $_SESSION['mensaje'] = "Canción actualizada correctamente.";
                header("Location: ../Canciones.php");
                exit();
            } else {
                $error = "No se pudo actualizar la canción.";
            }
        }
    }
}

if (isset($_POST['borrarCancion'])) {
    if ($cancion->borrar($id)) {
        $_SESSION['mensaje'] = "Canción eliminada correctamente.";
        header("Location: ../Canciones.php");
        exit();
    } else {
        $error = "No se pudo eliminar la canción.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Canción</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/fontawesome-all.min.css">
    <link rel="stylesheet" href="../css/tooplate-style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(-45deg, #ffdde1, #ee9ca7, #a1c4fd, #c2e9fb);
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

        .edit-cancion-container {
  margin-top: 60px; /* espacio extra */
}


    .navbar {
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
    background-color: rgba(0, 0, 0, 0.7);
    border-bottom: 2px solid white;
}

        .edit-cancion-container {
            background-color: #ffffffee;
            border: 4px solid #8e44ad;
            border-radius: 20px;
            padding: 40px 50px;
            width: 100%;
            max-width: 700px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .edit-cancion-container h2 {
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
            border: 2px solid #8e44ad;
            border-radius: 10px;
            font-size: 1rem;
            padding: 12px 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #7b2cbf;
            background-color: #f5ebff;
            box-shadow: none;
        }

        .btn-guardar, .btn-borrar {
            padding: 12px 20px;
            font-weight: bold;
            border-radius: 10px;
            width: 48%;
            border: none;
        }

        .btn-guardar {
            background-color: #8e44ad;
            color: #fff;
        }

        .btn-guardar:hover {
            background-color: #6c3483;
        }

        .btn-borrar {
            background-color: #e74c3c;
            color: white;
        }

        .btn-borrar:hover {
            background-color: #c0392b;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
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

<div class="edit-cancion-container">
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <h2>Editar Canción</h2>

    <form method="POST" action="" enctype="multipart/form-data">
        <label for="titulo">Título:</label>
        <input type="text" class="form-control" name="titulo" value="<?= htmlspecialchars($c->titulo) ?>">

        <label for="duracion">Duración:</label>
        <input type="text" class="form-control" name="duracion" value="<?= htmlspecialchars($c->duracion) ?>" placeholder="Ej: 03:45">

        <label for="album_id">Álbum:</label>
        <select class="form-select" name="album_id">
            <option value="0">-- Selecciona un álbum --</option>
            <?php foreach ($lista_albumes as $al): ?>
                <option value="<?= $al->id ?>" <?= ($c->album_id == $al->id) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($al->titulo) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="artista_id">Artista:</label>
        <select class="form-select" name="artista_id">
            <option value="0">-- Selecciona un artista --</option>
            <?php foreach ($lista_artistas as $art): ?>
                <option value="<?= $art->id ?>" <?= ($c->artista_id == $art->id) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($art->nombre) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <div class="mb-3 d-flex align-items-center gap-3">
    <label for="imagen" class="form-label mb-0" style="min-width: 100px;">Imagen:</label>
    <input type="file" class="form-control" name="imagen" id="imagen" accept="image/*" style="flex: 1;">
</div>
<?php if (!empty($c->imagen)): ?>
    <div class="mb-3">
        <img src="../img_blog_musica/Canciones/<?= htmlspecialchars($c->imagen) ?>" alt="Imagen actual" class="img-thumbnail" style="max-height: 150px;">
    </div>
<?php endif; ?>


       <div class="mb-3 d-flex align-items-center gap-3">
    <label for="archivo_audio" class="form-label mb-0" style="min-width: 150px;">Archivo de audio:</label>
    <input type="file" class="form-control" name="archivo_audio" accept="audio/*" style="flex: 1;">
</div>
<?php if (!empty($c->archivo_audio)): ?>
    <div class="mb-3">
        <audio controls style="width: 100%;">
            <source src="../audios/<?= htmlspecialchars($c->archivo_audio) ?>" type="audio/mpeg">
            Tu navegador no soporta audio HTML5.
        </audio>
    </div>
<?php endif; ?>


        <div class="button-group">
            <button type="submit" name="editarCancion" class="btn-guardar">Guardar Cambios</button>
            <button type="submit" name="borrarCancion" class="btn-borrar" onclick="return confirm('¿Estás seguro de borrar esta canción?');">Borrar Canción</button
