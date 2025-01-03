<?php

require_once __DIR__ . '/vendor/autoload.php';
session_start();

use App\Models\Alojamiento;

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin']) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alojamiento_id = $_POST['alojamiento_id'] ?? 0;
    
    $alojamiento = new Alojamiento();
    if ($alojamiento->addToUser($_SESSION['user_id'], $alojamiento_id)) {
        header('Location: account.php?added=1');
        exit();
    }
    
    header('Location: index.php?error=1');
    exit();
}
