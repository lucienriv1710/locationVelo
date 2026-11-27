
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion - Location de vélos</title>
</head>
<body>
    <h1>Connexion employés</h1>

    <?php if ($erreur): ?>
        <p><?= htmlspecialchars($erreur, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <form method="post" action="index.php?page=login">
        <p><label>Identifiant <input type="text" name="login" required></label></p>
        <p><label>Mot de passe <input type="password" name="password" required></label></p>
        <button type="submit">Se connecter</button>
    </form>
</body>
</html>