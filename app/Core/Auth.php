<?php
declare(strict_types=1);

namespace App\Core;

final class Auth
{
    public static function isAuthenticated(): bool
    {
        return isset($_SESSION['user']['id'], $_SESSION['user']['role']);
    }

    public static function isAdmin(): bool
    {
        return self::isAuthenticated() && $_SESSION['user']['role'] === 'admin';
    }

    public static function requireLogin()
    {
        if (!self::isAuthenticated()) {
            header('Location: index.php?page=login');
            exit;
        }
    }

    public static function requireAdmin()
    {
        self::requireLogin();
        if (!self::isAdmin()) {
            http_response_code(403);
            exit('Accès refusé');
        }
    }

}