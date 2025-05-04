<?php
session_start();
include "../config/Mysql.php";
include "../modelos/Album.php";
include "../modelos/Artista.php";

$base = new Mysql();
$cx = $base->connect();
$album = new Album($cx);
$artista = new Artista($cx);

if (!isset($_GET['id'])) {
    header("Location: ../Albumes.php");
    exit();
}

$id = $_GET['id'];
$a = $album->getAlbum($id);
$lista_artistas = $artista->listar($_SESSION['id'], $_SESSION['rol_id']);

if (isset($_POST['editarAlbum'])) {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha'];
    $artista_id = $_POST['artista_id'];
    $imagen = "";

    if (empty($titulo) || empty($descripcion) || empty($fecha) || $artista_id == 0) {
        $error = "Todos los campos son obligatorios.";
    } else {
        if ($_FILES['imagen']['error'] == 0) {
            $img = $_FILES['imagen']['name'];
            $ext = pathinfo($img, PATHINFO_EXTENSION);
            $newName = uniqid() . "." . $ext;
            $path = "../img_blog_musica/Albumes/" . $newName;
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $path)) {
                $imagen = $newName;
            } else {
                $error = "Error al guardar la nueva imagen.";
            }
        }

        if (!isset($error)) {
            if ($album->editar($id, $titulo, $imagen, $descripcion, $fecha, $artista_id)) {
                $_SESSION['mensaje'] = "Álbum actualizado con éxito.";
header("Location: ../Albumes.php");
                exit();
            } else {
                $error = "No se pudo actualizar el álbum.";
            }
        }
    }
}



if (isset($_POST['borrarAlbum'])) {
    if ($album->borrar($id)) {
        $_SESSION['mensaje'] = "Album eliminado correctamente";
        header("Location: ../Albumes.php");
        exit();
    } else {
        $error = "No se pudo eliminar el álbum.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Álbum</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/fontawesome-all.min.css">
    <link rel="stylesheet" href="../css/tooplate-style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
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

        .edit-album-container {
  margin-top: 80px; /* espacio extra */
  
}


    .navbar {
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
    background-color: rgba(0, 0, 0, 0.7);
    border-bottom: 2px solid white;
}

        .edit-album-container {
            background-color: rgb(240, 252, 255);
            border: 4px solid #1abc9c;
            border-radius: 20px;
            padding: 40px 50px;
            width: 100%;
            max-width: 700px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .edit-album-container h2 {
            font-family: 'Roboto', sans-serif;
            font-size: 2.5rem;
            color: #1abc9c;
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .form-control, .form-select {
            background-color: #ffffff;
            border: 2px solid #1abc9c;
            border-radius: 10px;
            font-size: 1rem;
            padding: 12px 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #1abc9c;
            background-color: #ecf7ff;
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
            background-color: #1abc9c;
            color: #fff;
        }

        .btn-guardar:hover {
            background-color: #1abc9c;
        }

        .btn-borrar {
            background-color: #e74c3c;
            color: white;
        }

        .btn-borrar:hover {
            background-color: #c0392b;
        }

        .alert {
            font-size: 1rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
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


<div class="edit-album-container">
    <?php if (isset($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $error ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <h2>Editar Álbum</h2>

    <form method="POST" action="" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $a->id ?>">

        <label for="titulo">Título:</label>
        <input type="text" class="form-control" name="titulo" id="titulo" value="<?= htmlspecialchars($a->titulo) ?>">

        <label for="descripcion">Descripción:</label>
        <textarea class="form-control" name="descripcion" rows="4"><?= htmlspecialchars($a->descripcion) ?></textarea>

        <label for="fecha">Fecha de lanzamiento:</label>
        <input type="datetime-local" class="form-control" name="fecha" id="fecha" value="<?= date('Y-m-d\TH:i', strtotime($a->fecha_lanzamiento)) ?>">

        <label for="artista_id">Artista:</label>
        <select class="form-select" name="artista_id" id="artista_id">
            <option value="0">-- Selecciona un artista --</option>
            <?php foreach ($lista_artistas as $art): ?>
                <option value="<?= $art->id ?>" <?= ($a->artista_id == $art->id) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($art->nombre) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="imagen">Imagen:</label>
        <input type="file" class="form-control" name="imagen" id="imagen">

        <?php if (!empty($a->imagen)): ?>
            <div class="mt-2">
                <img src="../img_blog_musica/Albumes/<?= htmlspecialchars($a->imagen) ?>" alt="Imagen actual" class="img-thumbnail" style="max-height: 150px;">
            </div>
        <?php endif; ?>

        <div class="button-group">
            <button type="submit" name="editarAlbum" class="btn-guardar">Guardar Cambios</button>
            <button type="submit" name="borrarAlbum" class="btn-borrar" onclick="return confirm('¿Estás seguro de que deseas borrar este álbum?');">Borrar Álbum</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</script>
</body>
</html>
