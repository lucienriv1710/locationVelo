# Location de vélos

## Installation

Prérequis : PHP 8.1+, Composer, MySQL (MAMP).

1. `composer install` — génère `vendor/` (chargement automatique des classes).
2. Crée la base : importe `Database/script.sql` dans phpMyAdmin (onglet « Importer »).
3. `cp config/config.example.php config/config.php`, puis adapte le port et les identifiants MySQL si tu n'utilises pas MAMP.

## Architecture (MVC)

```
locationVelo/
├── app/
│   ├── Database/              ← connexion à la base
│   │   └── Database.php       ← connexion PDO (Singleton)
│   ├── Controllers/           ← C : reçoivent la requête, appellent le modèle, choisissent la vue
│   │   └── Admin/             ← contrôleurs du tableau de bord employés
│   ├── Models/                ← M : accès aux tables (users, bikes, reservations)
│   └── Views/                 ← V : HTML affiché
│       ├── layouts/           ← gabarit commun (en-tête, menu, pied de page)
│       ├── public/            ← pages de l'interface publique
│       └── admin/             ← pages du tableau de bord employés
└── public/                    ← seul dossier accessible depuis le navigateur
    └── assets/
        ├── css/
        ├── js/                ← AJAX
        └── img/
            └── bikes/         ← photos des vélos
```
