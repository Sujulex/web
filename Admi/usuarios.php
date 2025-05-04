<?php 
session_start();

include "../config/Mysql.php";
include "../modelos/Usuario.php";

$base = new Mysql();
$cx = $base->connect();
$usuario = new Usuario($cx);

if (isset($_GET['mensaje'])) {
    $mensaje = $_GET['mensaje'];
}
$usuarios_pagina = $usuario->listar(); // Trae todos los usuarios

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Usuarios</title>

<!-- CSS -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400">
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="../css/fontawesome-all.min.css">
<link rel="stylesheet" href="../css/tooplate-style.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">


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
  margin: 0;
  padding: 0;
}

.navbar {
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
    background-color: rgba(0, 0, 0, 0.7);
    border-bottom: 2px solid white;
}

.usuarios-container {
    background-color:rgb(248, 201, 201);
    border: 4px solid #A14ea8;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    margin: 50px auto;
    max-width: 1200px;
    width: 100%;
}

.usuarios-header {
    font-family: 'Roboto', sans-serif;
    font-size: 3rem;
    color:rgb(225, 113, 113);
    text-align: center;
    margin-bottom: 40px;
    text-transform: uppercase;
    letter-spacing: 2px;
}

.table {
    width: 100%;
    background-color: #fff;
    border-radius: 15px;
    overflow: hidden;
}

.table thead {
    background-color: #A6D4F1;
    color: #fff;
    font-weight: bold;
}

.table-hover tbody tr:hover {
    background-color: #f2f2f2;
}

.table td, .table th {
    text-align: center;
    vertical-align: middle;
}

#tblUsuarios {
    font-family: 'Roboto', sans-serif;
    font-size: 1rem;
    color: #333;
}

#tblUsuarios tbody tr:hover {
    background-color: #fff0d5;
}

.btn-editar {
    background-color:rgb(60, 153, 150);
    color: white;
    border-radius: 10px;
    padding: 6px 14px;
    font-size: 0.9rem;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.btn-editar:hover {
    background-color:rgb(2, 103, 118);
}

/* Alertas */
.alert {
    position: relative;
    padding-right: 3rem;
    font-family: 'Open Sans', sans-serif;
    font-size: 1.1rem;
}

.alert .btn-close {
    position: absolute;
    top: 0.5rem;
    right: 1rem;
}
</style>
</head>

<br>

<!-- NAVBAR -->
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
<br>

</br>
<!-- Contenido -->
<div class="usuarios-container">

  <?php if (isset($error)): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong><?= $error ?></strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
  </div>
  <?php endif; ?>

  <?php if (isset($mensaje)): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong><?= $mensaje ?></strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
  </div>
  <?php endif; ?>

  <h2 class="usuarios-header">Lista de Usuarios</h2>
  <div class="mb-3 text-end">
  
</div>

  <div class="table-responsive">
    <table id="tblUsuarios" class="table table-striped table-hover">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Email</th>
          <th>Rol</th>
          <th>Fecha de Creación</th>                       
          <th class="acciones">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($usuarios_pagina as $u): ?>
          <tr>
            <td><?= $u->id ?></td>
            <td><?= $u->nombre ?></td>
            <td><?= $u->email ?></td>
            <td><?= $u->rol ?></td>
            <td><?= $u->fecha_creacion ?></td>
            <td class="acciones">
              <a href="editar_usuario.php?id=<?= $u->id ?>" class="btn btn-editar">
                <i class="bi bi-pencil-fill"></i> Editar
              </a>
            </td>
          </tr>
        <?php endforeach; ?>                       
      </tbody>       
    </table>
  </div>
  



</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>


// Auto-cerrar alertas
setTimeout(function() {
    var alert = document.querySelector('.alert');
    if (alert) {
        var bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
        bsAlert.close();
    }
}, 5000); // 5 segundos
</script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>
  $(document).ready(function () {
    $('#tblUsuarios').DataTable({
      pageLength: 01,
      language: {
        search: "Buscar por nombre:",
        lengthMenu: "Mostrar _MENU_ registros",
        zeroRecords: "No se encontraron usuarios",
        info: "Mostrando _START_ a _END_ de _TOTAL_ usuarios",
        infoEmpty: "No hay registros",
        infoFiltered: "(filtrado de _MAX_ registros)",
        paginate: {
          previous: "Anterior",
          next: "Siguiente"
        }
      },
      
    });
  });
</script>



</body>
</html>
