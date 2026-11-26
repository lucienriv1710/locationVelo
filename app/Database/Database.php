<?php

namespace App\Database;

use PDO;

class Database
{
    private static ?Database $instance = null;
    private PDO $pdo;

    // private : impossible de faire "new Database()" depuis l'extérieur
    private function __construct()
    {
        $config = require dirname(__DIR__, 2) . '/config/config.php';
        $db = $config['db'];

        $this->pdo = new PDO(
            "mysql:host={$db['host']};port={$db['port']};dbname={$db['name']};charset={$db['charset']}",
            $db['user'],
            $db['password'],
            [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
    }

    // Empêche la copie de l'instance
    private function __clone() {}

    // Point d'accès unique : crée la connexion la première fois, puis renvoie toujours la même
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}
