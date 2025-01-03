<?php

namespace App\Models;

use App\Config\Database;

class User {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function register($username, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        
        try {
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$username, $email, $hashedPassword]);
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function login($email, $password) {
        $query = "SELECT * FROM users WHERE email = ?";
        
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$email]);
            $user = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                return $user;
            }
            return false;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function getAlojamientos($userId) {
        $query = "SELECT a.* FROM alojamientos a 
                  INNER JOIN user_alojamientos ua ON a.id = ua.alojamiento_id 
                  WHERE ua.user_id = ?";
        
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$userId]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }
}