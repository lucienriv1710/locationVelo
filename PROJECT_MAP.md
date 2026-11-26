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
| `.gitignore` | Exclut `/vendor/` et `/config/config.php`. |
| `README.md` | Instructions d'installation (composer, BDD, config) + architecture MVC. |
| `location_de_velos.pdf` | Sujet du TP. |

### `Database/`
| Fichier | Rôle |
|---|---|
| `Database/script.sql` | Script SQL **utilisé** : crée la base `location_velo` et les tables. |

### `config/`
| Fichier | Rôle |
|---|---|
| `config/config.example.php` | Modèle suivi par git (valeurs MAMP par défaut). À copier en `config/config.php`. |
| `config/config.php` | Config locale, **ignorée par git**. Retourne `['db' => host, port, name, user, password, charset]`. Lue par `Database.php`. |

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

### `public/`
| Fichier / dossier | Rôle |
|---|---|
| `public/assets/css/style.css` | CSS natif responsive (mobile first, sans bibliothèque). Variables `:root`, `.container`, `.header`/`.nav`, `.grid` (1 col → 2 cols ≥ 768px → 3 cols ≥ 1024px), `.card`, formulaires, `.btn`/`.btn-danger`, `.table-wrapper` (défilement horizontal), `.alert`, `.badge-pending/accepted/rejected`. |
| `public/assets/js/`, `img/bikes/` | JS (AJAX) et photos des vélos — vides. |

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

- Aucun pour l'étape Setup. Responsive en CSS natif (pas de Bootstrap). `style.css` sera relié quand le gabarit `Views/layouts/` existera.

## Dernières modifications

| Date | Fichier | Résumé |
|---|---|---|
| 2026-11-26 | `public/assets/css/style.css` | Création du CSS natif responsive (choix : pas de Bootstrap). Testé à 375 / 768 / 1280 px. |
| 2026-11-26 | `config/`, `.gitignore`, `README.md` | Ajout de `config.example.php`, `config.php` ignoré par git, section Installation dans le README. |
| 2026-11-26 | `config/config.php` (local) | Mot de passe MySQL remis à `root` (vide = connexion refusée par MAMP). |
| 2026-11-26 | `PROJECT_MAP.md` | Création de l'index du projet. |
| 2026-11-26 | `main` | Fusion de `setup/projeLeo` : Composer, `config/config.php`, `Database.php` avec namespace + config, `.gitignore`, suppression de `create_admin.php`. |
