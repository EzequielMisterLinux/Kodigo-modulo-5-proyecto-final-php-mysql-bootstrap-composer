<?php

require_once __DIR__ . '/vendor/autoload.php';
session_start();

use App\Models\Alojamiento;

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $precio = $_POST['precio'] ?? 0;
    $ubicacion = $_POST['ubicacion'] ?? '';
    $imagen_url = $_POST['imagen_url'] ?? '';
    
    $alojamiento = new Alojamiento();
    if ($alojamiento->create($nombre, $descripcion, $precio, $ubicacion, $imagen_url)) {
        header('Location: account.php?created=1');
        exit();
    }
    
    header('Location: account.php?error=1');
    exit();
}

