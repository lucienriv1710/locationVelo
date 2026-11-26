<?php

$pdo = new PDO(
    'mysql:host=127.0.0.1;port=8889;dbname=location_velo;charset=utf8mb4',
    'root',
    'root',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

$login     = readline('Login admin : ');
$firstname = readline('Prénom : ');
$lastname  = readline('Nom : ');
$password  = readline('Mot de passe : ');

if (strlen($password) < 8) {
    exit("Le mot de passe doit faire au moins 8 caractères.\n");
}

$stmt = $pdo->prepare(
    'INSERT INTO users (firstname, lastname, login, password, role)
    VALUES (:firstname, :lastname, :login, :password, "admin")
    ON DUPLICATE KEY UPDATE password = VALUES(password), role = "admin"'
);

$stmt->execute([
    'firstname' => $firstname,
    'lastname'  => $lastname,
    'login'     => $login,
    'password'  => password_hash($password, PASSWORD_DEFAULT),
]);

echo "Compte administrateur « $login » prêt";