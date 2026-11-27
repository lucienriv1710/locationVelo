<?php
declare(strict_types=1);

namespace App\Models;

use App\Database\Database;
use PDO;

class Bike
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function all(): array
    {
        return $this->db
            ->query('SELECT bike_id, registration_number, availability, photo FROM bikes ORDER BY registration_number')
            ->fetchAll();
    }

    public function exists(string $registrationNumber): bool
    {
        $stmt = $this->db->prepare('SELECT 1 FROM bikes WHERE registration_number = ?');
        $stmt->execute([$registrationNumber]);

        return $stmt->fetchColumn() !== false;
    }

    public function create(string $registrationNumber, bool $available, ?string $photo): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO bikes (registration_number, availability, photo) VALUES (?, ?, ?)'
        );
        $stmt->execute([$registrationNumber, $available ? 1 : 0, $photo]);
    }
}
