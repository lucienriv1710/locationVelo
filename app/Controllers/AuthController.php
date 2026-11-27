<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Models\User;

class AuthController
{
    public function login(): void
    {
        $erreur = '';
        $isPost = $_SERVER['REQUEST_METHOD'] === 'POST';

        if ($isPost) {
            $login = trim((string) ($_POST['login'] ?? ''));
            $password = (string) ($_POST['password'] ?? '');
            $user = $login !== '' ? (new User())->findByLogin($login) : false;

            if ($user && password_verify($password, (string) $user['password'])) {
                session_regenerate_id(true);
                $_SESSION['user'] = [
                    'id' => (int) $user['user_id'],
                    'nom' => $user['firstname'],
                    'role' => $user['role'],
                ];
                header('Location: index.php?page=reservations');
                exit;
            }
            $erreur = 'Identifiant ou mot de passe incorrect';
        }

        require __DIR__ . '/../Views/admin/Login.php';
    }

    public function logout()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Requête invalide');
        }

        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
        header('Location: index.php?page=login');
        exit;
    }
}