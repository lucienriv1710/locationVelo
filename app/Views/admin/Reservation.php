<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Réservations - Location de vélos</title>
</head>
<body>
<?php require __DIR__ . '/../layouts/menu.php'; ?>
<h1>Réservations en attente</h1>

<?php
$formaterDate = static function (?string $date): string {
    if ($date === null || trim($date) === '') {
        return 'Date indisponible';
    }

    $horodatage = strtotime($date);
    return $horodatage === false ? 'Date indisponible' : date('d/m/Y H:i', $horodatage);
};
?>

<?php if (!$reservations): ?>
    <p>Aucune réservation en attente.</p>
<?php else: ?>
<div>
<table>
    <caption>Demandes à traiter</caption>
    <thead>
        <tr>
            <th>N°</th><th>Vélo</th><th>Demandeur</th>
            <th>Du</th><th>Au</th><th>Demandée le</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($reservations as $r): ?>
            <tr>
                <td><?= htmlspecialchars($r['res_num'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($r['registration_number'], ENT_QUOTES, 'UTF-8') ?></td>
                <td>
                    <?= htmlspecialchars($r['citizen_name'], ENT_QUOTES, 'UTF-8') ?><br>
                    <a href="mailto:<?= htmlspecialchars($r['citizen_email'], ENT_QUOTES, 'UTF-8') ?>">
                        <?= htmlspecialchars($r['citizen_email'], ENT_QUOTES, 'UTF-8') ?>
                    </a>
                </td>
                <td><?= htmlspecialchars($formaterDate($r['start_date'] ?? null), ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($formaterDate($r['end_date'] ?? null), ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($formaterDate($r['res_date'] ?? null), ENT_QUOTES, 'UTF-8') ?></td>
                <td>
                    <form method="post" action="index.php?page=reservation_process">
                        <input type="hidden" name="res_id" value="<?= (int) $r['res_id'] ?>">
                        <button type="submit" name="decision" value="accept">Valider</button>
                        <button type="submit" name="decision" value="reject">Refuser</button>
                    </form>
                    <?php if (\App\Core\Auth::isAdmin()): ?>
                        <form method="post" action="index.php?page=reservation_delete">
                            <input type="hidden" name="res_id" value="<?= (int) $r['res_id'] ?>">
                            <button type="submit">Supprimer</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>
<?php endif; ?>
</body>
</html>