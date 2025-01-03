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
    if ($alojamiento->removeFromUser($_SESSION['user_id'], $alojamiento_id)) {
        header('Location: account.php?removed=1');
        exit();
    }
    
    header('Location: account.php?error=1');
    exit();
}