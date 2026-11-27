<?php

use App\Controllers\AuthController;
use App\Controllers\BikeController;
use App\Controllers\ReservationController;
use App\Controllers\UserController;

session_start();

require_once __DIR__ . '/app/Database/Database.php';
require_once __DIR__ . '/app/Core/Auth.php';
require_once __DIR__ . '/app/Models/User.php';
require_once __DIR__ . '/app/Models/Bike.php';
require_once __DIR__ . '/app/Models/Reservation.php';
require_once __DIR__ . '/app/Controllers/AuthController.php';
require_once __DIR__ . '/app/Controllers/BikeController.php';
require_once __DIR__ . '/app/Controllers/ReservationController.php';
require_once __DIR__ . '/app/Controllers/UserController.php';

$page = $_GET['page'] ?? 'reservations';

switch ($page) {
    case 'login':
        $controller = new AuthController();
        $controller->login();
        break;

    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;

    case 'users':
        $controller = new UserController();
        $controller->index();
        break;

    case 'user_delete':
        $controller = new UserController();
        $controller->delete();
        break;

    case 'bikes':
        $controller = new BikeController();
        $controller->index();
        break;

    case 'reservations':
        $controller = new ReservationController();
        $controller->index();
        break;

    case 'reservation_process':
        $controller = new ReservationController();
        $controller->process();
        break;

    case 'reservation_delete':
        $controller = new ReservationController();
        $controller->delete();
        break;

    default:
        http_response_code(404);
        echo 'Page introuvable';
        break;
}
