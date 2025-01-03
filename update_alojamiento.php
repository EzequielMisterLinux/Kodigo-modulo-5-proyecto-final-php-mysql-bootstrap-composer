<?php

require_once __DIR__ . '/vendor/autoload.php';
session_start();

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header('Location: login.php');
    exit();
}

use App\Models\Alojamiento;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? 0;
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $precio = $_POST['precio'] ?? 0;
    $ubicacion = $_POST['ubicacion'] ?? '';
    $imagen_url = $_POST['imagen_url'] ?? '';

    $alojamiento = new Alojamiento();
    if ($alojamiento->update($id, $nombre, $descripcion, $precio, $ubicacion, $imagen_url)) {
        header('Location: admin_dashboard.php?updated=1');
        exit();
    }
    header('Location: admin_dashboard.php?error=1');
    exit();
}