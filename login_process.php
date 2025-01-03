<?php
require_once __DIR__ . '/vendor/autoload.php';
session_start();

use App\Models\User;


if (isset($_SESSION['user_id'])) {
    header('Location: account.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit();
}

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    header('Location: login.php?error=1');
    exit();
}

$user = new User();
$result = $user->login($email, $password);

if ($result) {
    $_SESSION['user_id'] = $result['id'];
    $_SESSION['username'] = $result['username'];
    $_SESSION['is_admin'] = $result['is_admin'];
    
    session_regenerate_id(true);
    
    if ($result['is_admin']) {
        header('Location: admin_dashboard.php');
    } else {
        header('Location: account.php');
    }
    exit();
}

header('Location: login.php?error=1');
exit();