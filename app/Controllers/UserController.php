<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Models\User;

class UserController
{
    public function index()
    {
        Auth::requireLogin();

        $model = new User();
        $erreur = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstname = trim((string) ($_POST['firstname'] ?? ''));
            $lastname = trim((string) ($_POST['lastname'] ?? ''));
            $login = trim((string) ($_POST['login'] ?? ''));
            $password = (string) ($_POST['password'] ?? '');
            $requestedRole = $_POST['role'] ?? 'employee';

            if ($firstname === '' || $lastname === '' || $login === '') {
                $erreur = 'Tous les champs d’identité sont obligatoires';
            } elseif (strlen($firstname) > 255 || strlen($lastname) > 255 || strlen($login) > 100) {
                $erreur = 'Un des champs dépasse la longueur autorisée';
            } elseif ($model->findByLogin($login)) {
                $erreur = 'Cet identifiant existe déjà';
            } elseif (strlen($password) < 8) {
                $erreur = 'Mot de passe : 8 caractères minimum';
            } elseif (Auth::isAdmin() && !in_array($requestedRole, ['admin', 'employee'], true)) {
                $erreur = 'Rôle invalide';
            } else {
                $role = Auth::isAdmin() ? $requestedRole : 'employee';
                $model->create($firstname, $lastname, $login, $password, $role);
                header('Location: index.php?page=users');
                exit;
            }
        }

        $users = $model->all();
        require __DIR__ . '/../Views/admin/Users.php';
    }

    public function delete()
    {
        Auth::requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(400);
            exit('Requête invalide');
        }

        $id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
        if ($id === false || $id === null || $id < 1) {
            http_response_code(400);
            exit('Identifiant utilisateur invalide');
        }
        if ($id === (int) $_SESSION['user']['id']) {
            http_response_code(400);
            exit('Vous ne pouvez pas supprimer votre propre compte');
        }

        (new User())->delete($id);
        header('Location: index.php?page=users');
        exit;
    }
}