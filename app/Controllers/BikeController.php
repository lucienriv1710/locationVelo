<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Models\Bike;

class BikeController
{
    public function index(): void
    {
        Auth::requireLogin();

        $model = new Bike();
        $erreur = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $registrationNumber = trim((string) ($_POST['registration_number'] ?? ''));
            if ($registrationNumber === '' || strlen($registrationNumber) > 50) {
                $erreur = 'Le numéro d’immatriculation est obligatoire (50 caractères maximum)';
            } elseif ($model->exists($registrationNumber)) {
                $erreur = 'Ce numéro d’immatriculation est déjà utilisé';
            }

            $photo = null;
            $upload = $_FILES['photo'] ?? null;
            if (
                $erreur === ''
                && is_array($upload)
                && isset($upload['error'], $upload['size'], $upload['tmp_name'])
                && $upload['error'] !== UPLOAD_ERR_NO_FILE
            ) {
                if ($upload['error'] !== UPLOAD_ERR_OK || $upload['size'] > 5 * 1024 * 1024) {
                    $erreur = 'La photo est invalide ou dépasse 5 Mo';
                } else {
                    $mimeType = (new \finfo(FILEINFO_MIME_TYPE))->file($upload['tmp_name']);
                    $extensions = [
                        'image/jpeg' => 'jpg',
                        'image/png' => 'png',
                        'image/webp' => 'webp',
                    ];
                    if (!is_string($mimeType) || !isset($extensions[$mimeType])) {
                        $erreur = 'La photo doit être au format JPG, PNG ou WEBP';
                    } else {
                        $filename = bin2hex(random_bytes(16)) . '.' . $extensions[$mimeType];
                        $uploadDirectory = dirname(__DIR__, 2) . '/assets/img/bikes';
                        if (!is_dir($uploadDirectory) && !mkdir($uploadDirectory, 0755, true) && !is_dir($uploadDirectory)) {
                            throw new \RuntimeException('Impossible de créer le dossier de photos.');
                        }
                        if (!move_uploaded_file($upload['tmp_name'], $uploadDirectory . '/' . $filename)) {
                            throw new \RuntimeException('Impossible d’enregistrer la photo envoyée.');
                        }
                        $photo = $filename;
                    }
                }
            }

            if ($erreur === '') {
                $disponible = isset($_POST['availability']) ? 1 : 0;
                $model->create($registrationNumber, (bool) $disponible, $photo);
                header('Location: index.php?page=bikes');
                exit;
            }
        }

        $bikes = $model->all();
        require __DIR__ . '/../Views/admin/Bike.php';
    }
}