<?php

class Database
{
    private static ?Database $instance = null;
    private PDO $pdo;

    // private : impossible de faire "new Database()" depuis l'extérieur
    private function __construct()
    {
        $this->pdo = new PDO(
            'mysql:host=127.0.0.1;port=8889;dbname=location_velo;charset=utf8mb4',
            'root',
            'root',
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
