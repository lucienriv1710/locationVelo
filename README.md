# Location de vélos

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
