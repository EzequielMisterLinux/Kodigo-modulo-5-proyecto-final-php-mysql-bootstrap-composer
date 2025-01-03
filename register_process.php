<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\User;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($password !== $confirm_password) {
        header('Location: register.php?error=1');
        exit();
    }

    $user = new User();
    if ($user->register($username, $email, $password)) {
        header('Location: login.php?registered=1');
        exit();
    }

    header('Location: register.php?error=1');
    exit();
}

