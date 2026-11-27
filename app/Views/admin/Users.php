<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion des comptes - Location de vélos</title>
</head>
<body>
<?php require __DIR__ . '/../layouts/menu.php'; ?>
<h1>Gestion des comptes</h1>

<?php if ($erreur !== ''): ?>
    <p><?= htmlspecialchars($erreur, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>

<table>
    <caption>Comptes enregistrés</caption>
    <thead>
        <tr><th>Nom</th><th>Identifiant</th><th>Rôle</th><th>Actions</th></tr>
    </thead>
    <tbody>
        <?php if ($users === []): ?>
            <tr><td>Aucun compte enregistré.</td></tr>
        <?php else: ?>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= htmlspecialchars($u['firstname'] . ' ' . $u['lastname'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($u['login'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($u['role'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td>
                        <?php if (\App\Core\Auth::isAdmin() && (int) $u['user_id'] !== (int) $_SESSION['user']['id']): ?>
                            <form method="post" action="index.php?page=user_delete">
                                <input type="hidden" name="user_id" value="<?= (int) $u['user_id'] ?>">
                                <button type="submit">Supprimer</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<h2>Créer un compte</h2>
<form method="post" action="index.php?page=users">
    <p><label>Prénom <input name="firstname" required></label></p>
    <p><label>Nom <input name="lastname" required></label></p>
    <p><label>Identifiant <input name="login" required></label></p>
    <p><label>Mot de passe <input type="password" name="password" required></label></p>
    <p>
        <label for="role">Rôle</label>
        <?php if (\App\Core\Auth::isAdmin()): ?>
            <select id="role" name="role">
                <option value="employee">Employé</option>
                <option value="admin">Administrateur</option>
            </select>
        <?php else: ?>
            <input id="role" type="text" value="Employé" disabled>
            <input type="hidden" name="role" value="employee">
        <?php endif; ?>
    </p>
    <button type="submit">Créer</button>
</form>
</body>
</html>