<?php
namespace App\Models;
use App\Config\Database;

class Alojamiento {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function getAll() {
        $query = "SELECT * FROM alojamientos";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function getById($id) {
        $query = "SELECT * FROM alojamientos WHERE id = ?";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function create($nombre, $descripcion, $precio, $ubicacion, $imagen_url) {
        $query = "INSERT INTO alojamientos (nombre, descripcion, precio, ubicacion, imagen_url) 
                 VALUES (?, ?, ?, ?, ?)";
        try {
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$nombre, $descripcion, $precio, $ubicacion, $imagen_url]);
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function update($id, $nombre, $descripcion, $precio, $ubicacion, $imagen_url) {
        $query = "UPDATE alojamientos 
                 SET nombre = ?, descripcion = ?, precio = ?, ubicacion = ?, imagen_url = ? 
                 WHERE id = ?";
        try {
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$nombre, $descripcion, $precio, $ubicacion, $imagen_url, $id]);
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function delete($id) {
        // Primero eliminar las reservaciones relacionadas
        $query1 = "DELETE FROM user_alojamientos WHERE alojamiento_id = ?";
        $query2 = "DELETE FROM alojamientos WHERE id = ?";
        
        try {
            $this->conn->beginTransaction();
            
            $stmt1 = $this->conn->prepare($query1);
            $stmt1->execute([$id]);
            
            $stmt2 = $this->conn->prepare($query2);
            $result = $stmt2->execute([$id]);
            
            $this->conn->commit();
            return $result;
        } catch (\PDOException $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function addToUser($userId, $alojamientoId) {
        $query = "INSERT INTO user_alojamientos (user_id, alojamiento_id) VALUES (?, ?)";
        try {
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$userId, $alojamientoId]);
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function removeFromUser($userId, $alojamientoId) {
        $query = "DELETE FROM user_alojamientos WHERE user_id = ? AND alojamiento_id = ?";
        try {
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$userId, $alojamientoId]);
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function getAllReservations() {
        $query = "SELECT u.username, a.nombre as nombre_alojamiento, ua.created_at as fecha_reserva 
                 FROM user_alojamientos ua 
                 JOIN users u ON ua.user_id = u.id 
                 JOIN alojamientos a ON ua.alojamiento_id = a.id 
                 ORDER BY ua.created_at DESC";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }
}