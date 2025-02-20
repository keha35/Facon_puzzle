<?php

namespace App\Config;

class Database {
    private static $instance = null;
    private $connection = null;

    private function __construct() {
        try {
            $this->connection = new \PDO(
                "mysql:host=" . $_ENV['DB_HOST'] . 
                ";port=" . $_ENV['DB_PORT'] . 
                ";dbname=" . $_ENV['DB_DATABASE'],
                $_ENV['DB_USERNAME'],
                $_ENV['DB_PASSWORD'],
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                    \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
                ]
            );
        } catch (\PDOException $e) {
            throw new \Exception("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
} 