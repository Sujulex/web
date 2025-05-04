<?php
session_start();
include "config/Mysql.php";
include "modelos/Artista.php";
include "modelos/Album.php";
include "modelos/Cancion.php";

$base = new Mysql();
$cx = $base->connect();

$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

if ($keyword === '') {
    header("Location: index.php");
    exit;
}

$artista = new Artista($cx);
$album = new Album($cx);
$cancion = new Cancion($cx);

// Buscar artista
foreach ($artista->listar($_SESSION['id'] ?? null, $_SESSION['rol_id'] ?? null) as $a) {
    if (strcasecmp($a->nombre, $keyword) === 0) {
        header("Location: Artistas.php#artista-" . $a->id);
        exit;
    }
}

// Buscar álbum
foreach ($album->listar($_SESSION['id'] ?? null, $_SESSION['rol_id'] ?? null) as $al) {
    if (strcasecmp($al->titulo, $keyword) === 0) {
        header("Location: Albumes.php#album-" . $al->id);
        exit;
    }
}

// Buscar canción
foreach ($cancion->listar($_SESSION['id'] ?? null, $_SESSION['rol_id'] ?? null) as $c) {
    if (strcasecmp($c->titulo, $keyword) === 0) {
        header("Location: Canciones.php#cancion-" . $c->id);
        exit;
    }
}

// Si no encontró nada, redirige a index con un mensaje opcional
header("Location: index.php?mensaje=No se encontró ningún resultado");
exit;
