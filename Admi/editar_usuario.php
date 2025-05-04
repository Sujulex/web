<?php 
session_start();

include "../config/Mysql.php";
include "../modelos/Usuario.php";

$base = new Mysql();
$cx = $base->connect();
$user = new Usuario($cx);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $u = $user->getUsuario($id);
}

if (isset($_POST['editarUsuario'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $rol_id = $_POST['rol_id'];

    if (empty($nombre) || empty($email) || $rol_id == 0) {
        $error = "Todos los campos son obligatorios.";
    } else {
        if ($user->editarUsuario($id, $nombre, $email, $rol_id)) {
            if ($_SESSION['id'] == $id && $rol_id != 1) {
                session_destroy();
                header('Location: ../index.php');
                exit();
            }
            $mensaje = "Usuario editado con éxito.";
            header('Location: usuarios.php?mensaje=' . urlencode($mensaje));
            exit();
        } else {
            $error = "No se pudo actualizar el usuario.";
        }
    }
}

if (isset($_POST["borrarUsuario"])) {
    $id = $_POST["id"];
    if ($user->borrar($id)) {
        if ($_SESSION['id'] == $id) {
            session_destroy();
            header('Location: ../index.php');
            exit();
        }
        $mensaje = "Usuario eliminado con éxito.";
        header('Location: usuarios.php?mensaje=' . urlencode($mensaje));
        exit();
    } else {
        $error = "No se pudo eliminar el usuario.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/fontawesome-all.min.css">
    <link rel="stylesheet" href="../css/tooplate-style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">

    <style>
        @keyframes gradientBackground {
          0% { background-position: 0% 50%; }
          50% { background-position: 100% 50%; }
          100% { background-position: 0% 50%; }
        }

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

        .edit-user-container {
            background-color: rgb(252, 137, 137);
            border: 4px solid #A14ea8;
            border-radius: 20px;
            padding: 40px 50px;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .edit-user-container h2 {
            font-family: 'Roboto', sans-serif;
            font-size: 2.5rem;
            color: rgb(196, 66, 66);
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .form-control, .form-select {
            background-color: #ffffff;
            border: 2px solid #a57ec6;
            border-radius: 10px;
            font-size: 1rem;
            padding: 12px 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #ff9f00;
            background-color: #fce4ec;
            box-shadow: none;
        }

        .btn-guardar, .btn-borrar {
            border: none;
            padding: 12px 20px;
            font-weight: bold;
            border-radius: 10px;
            width: 48%;
            transition: all 0.3s ease;
        }

        .btn-guardar {
            background-color: #33cc99;
            color: #fff;
        }

        .btn-guardar:hover {
            background-color: #28a37e;
        }

        .btn-borrar {
            background-color: #ff4d4d;
            color: #fff;
        }

        .btn-borrar:hover {
            background-color: #cc0000;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
        }

        /* Estilo personalizado para alertas */
        .alert {
            font-size: 1rem;
            font-weight: bold;
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .alert-dismissible.fade.show {
            opacity: 1;
        }

        .alert-dismissible.fade {
            opacity: 0;
            transform: scale(0.95);
        }
    </style>
</head>

<body>

<div class="edit-user-container">

<?php if (isset($error)): ?>
<div class="alert alert-danger alert-dismissible fade show position-relative" role="alert">
    <strong><?= $error ?></strong>
    <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="alert" aria-label="Cerrar"></button>
</div>
<?php endif; ?>

<?php if (isset($mensaje)): ?>
<div class="alert alert-success alert-dismissible fade show position-relative" role="alert">
    <strong><?= $mensaje ?></strong>
    <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="alert" aria-label="Cerrar"></button>
</div>
<?php endif; ?>



    <h2>Editar Usuario</h2>

    <form method="POST" action="">
        <input type="hidden" name="id" value="<?= $u->id ?>">

        <label for="nombre" class="form-label">Nombre:</label>
        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingresa el nombre" value="<?= htmlspecialchars($u->nombre) ?>">

        <label for="email" class="form-label">Email:</label>
        <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($u->email) ?>" readonly>

        <label for="rol_id" class="form-label">Rol:</label>
        <select name="rol_id" id="rol_id" class="form-select">
            <option value="0">--Selecciona un rol--</option>
            <option value="1" <?= ($u->rol_id == 1) ? 'selected' : '' ?>>Administrador</option>
            <option value="2" <?= ($u->rol_id == 2) ? 'selected' : '' ?>>Registrado</option>
        </select>

        <div class="button-group mt-4">
            <button type="submit" name="editarUsuario" class="btn-guardar">Editar Usuario</button>
            <button type="submit" name="borrarUsuario" class="btn-borrar">Borrar Usuario</button>
        </div>

    </form>
</div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<script>
  setTimeout(function() {
    var alert = document.querySelector('.alert');
    if (alert) {
      var bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
      bsAlert.close();
    }
  }, 5000); // Se cierra después de 5 segundos
</script>


</body>
</html>
