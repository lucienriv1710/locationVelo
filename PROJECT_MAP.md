# PROJECT_MAP — Location de vélos

Index du projet : à consulter avant chaque tâche, à mettre à jour après chaque modification validée.

## Contexte

TP PHP orienté objet : MVC, Singleton (connexion BDD), AJAX, responsive.
Deux interfaces : publique (citoyens qui réservent) et tableau de bord employés (authentification).
Sujet complet : `location_de_velos.pdf`.

## Fichiers

### Racine
| Fichier | Rôle |
|---|---|
| `index.php` | Page HTML vide (placeholder du premier commit). Pas encore de point d'entrée MVC. |
| `script.sql` | Script SQL **original** fourni par le formateur (référence, non utilisé : `login INT`, pas de `role`). |
| `composer.json` / `composer.lock` | Autoload PSR-4 : `App\` → `app/`. Aucune dépendance externe. `vendor/` généré par `composer install`. |
| `.gitignore` | Exclut `/vendor/`. |
| `README.md` | Architecture MVC du projet. |
| `location_de_velos.pdf` | Sujet du TP. |

### `Database/`
| Fichier | Rôle |
|---|---|
| `Database/script.sql` | Script SQL **utilisé** : crée la base `location_velo` et les tables. |

### `config/`
| Fichier | Rôle |
|---|---|
| `config/config.php` | Retourne un tableau `['db' => host, port (8889 MAMP), name, user, password, charset]`. Suivi par git. |

### `app/` (MVC)
| Fichier / dossier | Rôle |
|---|---|
| `app/Database/Database.php` | `App\Database\Database` : connexion PDO en Singleton. Lit `config/config.php`. `getInstance()`, `getConnection()`. |
| `app/Controllers/` | Contrôleurs de l'interface publique — vide. |
| `app/Controllers/AdminController/` | Contrôleurs du tableau de bord employés — vide. |
| `app/Models/` | Modèles (accès aux tables) — vide. |
| `app/Views/layouts/` | Gabarit commun — vide. |
| `app/Views/public/` | Vues de l'interface publique — vide. |
| `app/Views/admin/` | Vues du tableau de bord — vide. |

### `public/` (non suivi par git : dossiers vides)
| Dossier | Rôle |
|---|---|
| `public/assets/css/`, `js/`, `img/bikes/` | CSS, JS (AJAX), photos des vélos — vides. |

## Base de données (`location_velo`)

| Table | Colonnes principales | Notes |
|---|---|---|
| `users` | `user_id`, `firstname`, `lastname`, `login` (VARCHAR, unique), `password` (hash bcrypt), `role` (`admin` / `employee`) | Personnel. `admin` = employé + droit de suppression. |
| `bikes` | `bike_id`, `registration_number`, `availability`, `photo` | |
| `reservations` | `user_id`, `bike_id`, `res_num` (unique), `res_date`, `start_date`, `end_date`, `status` (`pending` / `accepted` / `rejected`) | PK `(user_id, bike_id)`. FK vers `users` et `bikes`. |

Points ouverts :
- Pas de table pour les citoyens (`customers`) : `reservations` pointe vers `users`. À décider avant de coder les réservations.
- La PK `(user_id, bike_id)` empêche de réserver deux fois le même vélo.
- Compte admin : à créer via phpMyAdmin avec un hash `password_hash` (pas de script dans le projet).

## Routes

Aucune pour l'instant (pas de routeur ni de `public/index.php`).

## Reste à faire (étape Setup)

- Bootstrap / CSS responsive (prévu plus tard, pas encore choisi : CDN ou local).
- README : instructions d'installation (`composer install`, création BDD, config).
- Optionnel : `config/config.example.php` + `config/config.php` dans `.gitignore`.

## Dernières modifications

| Date | Fichier | Résumé |
|---|---|---|
| 2026-11-26 | `PROJECT_MAP.md` | Création de l'index du projet. |
| 2026-11-26 | `main` | Fusion de `setup/projeLeo` : Composer, `config/config.php`, `Database.php` avec namespace + config, `.gitignore`, suppression de `create_admin.php`. |
