<?php
namespace App\Config;

class Database {
    private static $instance = null;
    private $conn;

    private function __construct() {
        try {

            $projectRoot = dirname(dirname(__DIR__));
            

            if (!file_exists($projectRoot . '/.env')) {
                throw new \Exception('El archivo .env no existe en: ' . $projectRoot . '/.env');
            }

            $dotenv = \Dotenv\Dotenv::createImmutable($projectRoot);
            $dotenv->load();

            $required_vars = ['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS'];
            foreach ($required_vars as $var) {
                if (!isset($_ENV[$var])) {
                    throw new \Exception("Variable de entorno $var no está definida");
                }
            }

            $this->conn = new \PDO(
                "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'],
                $_ENV['DB_USER'],
                $_ENV['DB_PASS'],
                [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
            );

        } catch(\Exception $e) {
            error_log("Error de conexión: " . $e->getMessage());
            throw $e;
        }
    }

    public static function getInstance() {
        if(!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }
}