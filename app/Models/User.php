<?php
declare(strict_types=1);

namespace App\Models;

use App\Database\Database;
use PDO;

class User
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findByLogin(string $login): array|false
    {
        $stmt = $this->db->prepare('SELECT user_id, firstname, lastname, login, password, role FROM users WHERE login = ?');
        $stmt->execute([$login]);
        return $stmt->fetch();
    }

    public function all(): array
    {
        return $this->db
            ->query('SELECT user_id, firstname, lastname, login, role FROM users ORDER BY lastname, firstname')
            ->fetchAll();
    }

    public function create(string $firstname, string $lastname, string $login, string $password, string $role): void
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare('INSERT INTO users (firstname, lastname, login, password, role) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$firstname, $lastname, $login, $hash, $role]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM users WHERE user_id = ?');
        $stmt->execute([$id]);
    }
}