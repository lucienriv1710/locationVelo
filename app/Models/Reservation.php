<?php
declare(strict_types=1);

namespace App\Models;

use App\Database\Database;
use PDO;

class Reservation
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function pending(): array
    {
        $sql = <<<'SQL'
            SELECT r.res_id, r.res_num, r.res_date, r.start_date, r.end_date,
                   r.citizen_name, r.citizen_email, b.registration_number
            FROM reservations AS r
            INNER JOIN bikes AS b ON b.bike_id = r.bike_id
            WHERE r.status = 'pending'
            ORDER BY r.res_date ASC
            SQL;

        return $this->db->query($sql)->fetchAll();
    }

    public function setStatus(int $id, string $status, int $processedBy): void
    {
        if (!in_array($status, ['accepted', 'rejected'], true)) {
            throw new \InvalidArgumentException('Statut de réservation invalide.');
        }

        $stmt = $this->db->prepare(
            "UPDATE reservations SET status = ?, processed_by = ? WHERE res_id = ? AND status = 'pending'"
        );
        $stmt->execute([$status, $processedBy, $id]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM reservations WHERE res_id = ?');
        $stmt->execute([$id]);
    }
}