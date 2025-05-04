<?php 
  session_start();

  $mensaje = "";
if (isset($_SESSION['mensaje'])) {
  $mensaje = $_SESSION['mensaje'];
  unset($_SESSION['mensaje']);
}
  include "../config/Mysql.php";
  include "../modelos/Artista.php";

  $base = new Mysql();
  $cx = $base->connect();
  $artista = new Artista($cx);

  if (!isset($_GET['id'])) {
    header("Location: ../Artistas.php");
    exit();
  }

  $id = $_GET['id'];
  $a = $artista->getArtista($id);
  $titulo = "Editar Artista";

  if (isset($_POST['editarArtista'])) {
    $nombre = $_POST['titulo2'];
    $descripcion = $_POST['texto'];

    if (empty($nombre) || empty($descripcion)) {
      $error = "Todos los campos deben tener información";
    } else {
      $imagenFinal = $a->imagen;

      if ($_FILES['imagen']['error'] === 0) {
        $imagen = $_FILES['imagen']['name'];
        $imgArr = explode(".", $imagen);
        $rand = rand(1000, 9999);
        $nuevoNombreImagen = $imgArr[0] . $rand . "." . $imgArr[1];
        $rutaFinal = "../img_blog_musica/Artistas/" . $nuevoNombreImagen;

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaFinal)) {
          $imagenFinal = $nuevoNombreImagen;
        } else {
          $error = "Error al guardar la nueva imagen";
        }
      }

      if (!isset($error)) {
        if ($artista->editar($id, $nombre, $imagenFinal, $descripcion)) {
            $_SESSION['mensaje'] = "Artista editado correctamente";
            header("Location: ../Artistas.php");
                  
          exit();
        } else {
          $error = "No se ha podido editar el artista";
        }
      }
    }
  }

  if (isset($_POST['borrarArtista'])) {
    if ($artista->borrar($id)) {
        $_SESSION['mensaje'] = "Artista eliminado correctamente";
        header("Location: ../Artistas.php");
        
      exit();
    } else {
      $error = "No se pudo borrar el artista";
    }
  }
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?= $titulo ?></title>
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
    .artista-container {
  margin-top: 60px; /* espacio extra */
}


    .navbar {
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
    background-color: rgba(0, 0, 0, 0.7);
    border-bottom: 2px solid white;
}
    .artista-container {
      background-color: rgb(255, 255, 255);
      border: 4px solid #1abc9c;
      border-radius: 20px;
      padding: 40px 50px;
      width: 100%;
      max-width: 700px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .artista-container h2 {
      font-family: 'Roboto', sans-serif;
      font-size: 2.5rem;
      color: #16a085;
      text-align: center;
      margin-bottom: 30px;
      font-weight: bold;
      text-transform: uppercase;
    }

    .form-control, .form-select {
      background-color: #f2f2f2;
      border: 2px solid #1abc9c;
      border-radius: 10px;
      font-size: 1rem;
      padding: 12px 20px;
      margin-bottom: 20px;
    }

    .btn-editar, .btn-borrar {
      padding: 12px 20px;
      font-weight: bold;
      border-radius: 10px;
      border: none;
      width: 48%;
      margin: 10px 1%;
    }

    .btn-editar {
      background-color: #1abc9c;
      color: #fff;
    }

    .btn-borrar {
      background-color: #e74c3c;
      color: #fff;
    }

    .alert {
      font-size: 1rem;
      font-weight: bold;
    }
  </style>

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


</head>
<body>
<div class="artista-container">
  <?php if (isset($error)): ?>
    <div class="alert alert-danger"> <?= $error ?> </div>
  <?php endif; ?>

  <h2><?= $titulo ?></h2>

  <form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $a->id ?>">

    <label for="titulo2">Nombre:</label>
    <input type="text" class="form-control" name="titulo2" id="titulo2" value="<?= htmlspecialchars($a->nombre) ?>">

    <label for="imagen">Imagen:</label>
    <input type="file" class="form-control" name="imagen" id="imagen">
    <img src="../img_blog_musica/Artistas/<?= htmlspecialchars($a->imagen) ?>" alt="<?= htmlspecialchars($a->nombre) ?>" class="img-fluid rounded mt-2">

    <label for="texto">Descripción:</label>
    <textarea class="form-control" name="texto" rows="6"><?= htmlspecialchars($a->descripcion) ?></textarea>

    <div class="d-flex justify-content-between">
      <button type="submit" name="editarArtista" class="btn-editar">Guardar Cambios</button>
      <button type="submit" name="borrarArtista" class="btn-borrar" onclick="return confirm('¿Estás seguro de que deseas eliminar este artista?');">Borrar</button>
    </div>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
