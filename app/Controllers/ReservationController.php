<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Models\Reservation;

class ReservationController
{
    public function index(): void
    {
        Auth::requireLogin();

        $reservations = (new Reservation())->pending();
        require __DIR__ . '/../Views/admin/Reservation.php';
    }

    public function process(): void
    {
        Auth::requireLogin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(400);
            exit('Requête invalide');
        }

        $statuts = ['accept' => 'accepted', 'reject' => 'rejected'];
        $decision = $_POST['decision'] ?? '';
        $id = filter_input(INPUT_POST, 'res_id', FILTER_VALIDATE_INT);

        if (!is_string($decision) || !isset($statuts[$decision]) || $id === false || $id === null || $id < 1) {
            http_response_code(400);
            exit('Données de réservation invalides');
        }

        (new Reservation())->setStatus($id, $statuts[$decision], (int) $_SESSION['user']['id']);
        header('Location: index.php?page=reservations');
        exit;
    }

    public function delete(): void
    {
        Auth::requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(400);
            exit('Requête invalide');
        }

        $id = filter_input(INPUT_POST, 'res_id', FILTER_VALIDATE_INT);
        if ($id === false || $id === null || $id < 1) {
            http_response_code(400);
            exit('Identifiant de réservation invalide');
        }

        (new Reservation())->delete($id);
        header('Location: index.php?page=reservations');
        exit;
    }
}