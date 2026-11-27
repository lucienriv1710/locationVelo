<nav aria-label="Navigation principale">
    <a href="index.php?page=reservations">Réservations</a>
    <a href="index.php?page=bikes">Vélos</a>
    <a href="index.php?page=users">Comptes</a>
    <span>Connecté : <?= htmlspecialchars((string) ($_SESSION['user']['nom'] ?? ''), ENT_QUOTES, 'UTF-8') ?></span>
    <form method="post" action="index.php?page=logout">
        <button type="submit">Se déconnecter</button>
    </form>
</nav>
