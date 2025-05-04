<?php
    include "./config/Mysql.php";
    include "./modelos/Usuario.php";
    $base = new Mysql();
    $conexion = $base->connect();
    $usuario = new Usuario($conexion);

    if (isset($_POST['registrarse'])) {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmar_password = $_POST['confirmar_password'];

        if (empty($nombre) || empty($email) || empty($password) || empty($confirmar_password)) {
            $error = "Algunos campos están vacíos";
        } else {
            if ($password != $confirmar_password) {
                $error = "Las contraseñas no coinciden";
            } else {
                if ($usuario->validaEmail($email)) {
                    $error = "Ese correo ya existe";
                } else {
                    if ($usuario->registro($nombre, $email, $password)) {
                        $mensaje = "Registro exitoso";
                    } else {
                        $error = "No se pudo registrar";
                    }
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }
        .bg-gradient-pastel {
            background: linear-gradient(-45deg, rgb(160, 255, 241), #FFAFBD, rgb(14, 244, 163), #A7D9FF);
            background-size: 400% 400%;
            animation: gradient 10s ease infinite;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            padding: 30px;
            width: 100%;
            max-width: 500px;
            background: rgba(255, 255, 255, 0.95);
        }
        .btn-pastel {
            background-color: #A7D9FF;
            border: none;
            color: #333;
        }
        .btn-pastel:hover {
            background-color: #7FC7FF;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #A7D9FF;
        }
    </style>
</head>
<body>
<div class="bg-gradient-pastel">
    <div class="card">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><?= $error ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($mensaje)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><?= $mensaje ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <h2 class="text-center mb-4">Registro de Usuarios</h2>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="nombre" placeholder="Ingresa el nombre">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" placeholder="Ingresa el email">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" name="password" placeholder="Ingresa el password">
            </div>

            <div class="mb-3">
                <label for="confirmar_password" class="form-label">Confirmar Password:</label>
                <input type="password" class="form-control" name="confirmar_password" placeholder="Confirma tu password">
            </div>

            <button type="submit" name="registrarse" class="btn btn-pastel w-100 mb-2">Registrarse</button>
            <a href="index.php" class="btn btn-pastel w-100">Regresar al Inicio</a>

            <div class="text-center mt-3">
            <a href="Login.php" class="register-link">¿Ya tienes cuenta? Inicia sesión ahora</a>
        </div>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>




       