<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion des vélos - Location de vélos</title>
</head>
<body>
<?php require __DIR__ . '/../layouts/menu.php'; ?>
<h1>Vélos</h1>

<?php if ($erreur !== ''): ?>
    <p><?= htmlspecialchars($erreur, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>

<h2>Enregistrer un vélo</h2>
<form method="post" action="index.php?page=bikes">
    <p><label>Numéro d'immatriculation <input name="registration_number" required></label></p>
    <p><label><input type="checkbox" name="availability" checked> Disponible</label></p>
    <p><label>Photo (JPG, PNG ou WEBP, 5 Mo maximum) <input type="file" name="photo"></label></p>
    <button type="submit">Enregistrer</button>
</form>

<h2>Liste des vélos</h2>
<table>
    <caption>Vélos enregistrés</caption>
    <thead>
        <tr><th>Photo</th><th>Immatriculation</th><th>Disponibilité</th></tr>
    </thead>
    <tbody>
        <?php if ($bikes === []): ?>
            <tr><td>Aucun vélo enregistré.</td></tr>
        <?php else: ?>
            <?php foreach ($bikes as $b): ?>
                <tr>
                    <td>
                        <?php if (!empty($b['photo'])): ?>
                            <img src="assets/img/bikes/<?= rawurlencode($b['photo']) ?>"alt="Vélo <?= htmlspecialchars($b['registration_number'], ENT_QUOTES, 'UTF-8') ?>">
                        <?php else: ?>
                            Aucune photo
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($b['registration_number'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= $b['availability'] ? 'Disponible' : 'Indisponible' ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
</body>
</html>