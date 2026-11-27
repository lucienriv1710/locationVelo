# Location de vélos

Application PHP MVC de gestion des comptes employés, des vélos et des demandes
de réservation.

## Installation

1. Démarrer MySQL et importer `Database/script.sql` (ou `script.sql`).
2. Configurer la connexion avec les variables `DB_HOST`, `DB_PORT`, `DB_NAME`,
   `DB_USER` et `DB_PASSWORD`. Par défaut, la configuration correspond à MAMP
   (`127.0.0.1:3306`, base `location_velo`, utilisateur et mot de passe `root`).
3. Créer le premier compte administrateur. Générer d’abord un hash :

   ```sh
   php -r "echo password_hash('choisir-un-mot-de-passe', PASSWORD_DEFAULT), PHP_EOL;"
   ```

   Puis insérer le compte dans MySQL en remplaçant le hash et les informations :

   ```sql
   INSERT INTO users (firstname, lastname, login, password, role)
   VALUES ('Admin', 'Location', 'admin', 'COLLER_LE_HASH_ICI', 'admin');
   ```

4. Servir ce dossier avec PHP ou le placer dans le répertoire web de MAMP, puis
   ouvrir `index.php?page=login`.

Les contrôleurs sont dans `app/Controllers`, l’accès aux données dans
`app/Models`, les vues dans `app/Views` et la connexion PDO dans
`app/Database/Database.php`. Les photos des vélos sont enregistrées dans
`assets/img/bikes`; elles sont limitées à 5 Mo et aux formats JPG, PNG et WEBP.
