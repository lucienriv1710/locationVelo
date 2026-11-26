<?php
// Modèle de configuration.
// Copie ce fichier en config/config.php puis adapte les valeurs à ta machine.
// config/config.php est ignoré par git : tes réglages restent chez toi.

return [
    'db' => [
        'host'     => '127.0.0.1',
        'port'     => 8889,          // MAMP : 8889 — MySQL classique : 3306
        'name'     => 'location_velo',
        'user'     => 'root',
        'password' => 'root',        // MAMP : root — sinon souvent vide
        'charset'  => 'utf8mb4',
    ],
];
