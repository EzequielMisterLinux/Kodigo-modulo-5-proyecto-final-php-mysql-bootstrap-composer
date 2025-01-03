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
    
    $alojamiento = new Alojamiento();
    if ($alojamiento->delete($id)) {
        header('Location: admin_dashboard.php?deleted=1');
        exit();
    }
    header('Location: admin_dashboard.php?error=1');
    exit();
}
