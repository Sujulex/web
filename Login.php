<?php
session_start();

    include "config/Mysql.php";
    include "modelos/Usuario.php";
    $base = new Mysql();
    $cx = $base->connect();
    $user = new Usuario($cx);

    if (isset($_POST["acceder"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        if ($email=='' || empty($email) || $password=='' || empty($password)){
            $error = "Todos los campos son obligatorios";
        } else {
            if ($user->login($email, $password)) {
                $mensaje ="Acceso concedido";
                $u = $user->consultaEmail($email); 
                $_SESSION['auth'] = true;
                $_SESSION['id'] = $u->id;
                $_SESSION['nombre'] = $u->nombre;
                $_SESSION['email'] = $u->email;
                $_SESSION['rol_id'] = $u->rol_id;
                header ('Location: index.php');               
            } else {
                $error = "Usuario o contraseña incorrecto";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @keyframes gradientAnimation {
            0% {background-position: 0% 50%;}
            50% {background-position: 100% 50%;}
            100% {background-position: 0% 50%;}
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(-45deg, #fbc2eb, #a6c1ee,rgb(255, 254, 165),rgb(152, 255, 148));
            background-size: 400% 400%;
            animation: gradientAnimation 15s ease infinite;
            font-family: 'Open Sans', sans-serif;
        }
        .login-card {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            padding: 25px;
            width: 100%;
            max-width: 450px;
        }
        .btn-custom {
            background-color: #ffafcc;
            color: #333;
        }
        .btn-custom:hover {
            background-color: #ffc8dd;
        }
        .register-link {
            color: #6a5acd;
            text-decoration: none;
        }
        .register-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-card">

    <?php if (isset($error)):?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><?=$error?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif;?>

    <?php if (isset($mensaje)):?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong><?=$mensaje?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif;?>

    <h2 class="text-center mb-4">Acceso de Usuarios</h2>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Email:</label>
            <input type="email" class="form-control" name="email" placeholder="Ingresa el email">
        </div>

        <div class="mb-4">
            <label class="form-label">Contraseña:</label>
            <input type="password" class="form-control" name="password" placeholder="Ingresa la contraseña">
        </div>

        <button type="submit" name="acceder" class="btn btn-custom w-100">Acceder</button>

        <div class="text-center mt-3">
            <a href="index.php" class="btn btn-custom w-100">Regresar al Inicio</a>
        </div>

        <div class="text-center mt-3">
            <a href="registro.php" class="register-link">¿No tienes una cuenta? Regístrate ahora</a>
        </div>

    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
