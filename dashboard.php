<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit;
}

$role = $_SESSION['role'];

echo "<h1 id=titre_dashboard>Bienvenue, " . htmlspecialchars($_SESSION['username']) . " !</h1>";
if ($role === 'Admin') {
    echo "<a href='admin_page.php'>Gérer les utilisateurs</a>";
    echo "<a href='ajouter_salarie.php' class='btn'>Ajouter un Médecin</a>";
} elseif ($role === 'Infirmier') {
    echo "<a href='edit_content.php'>Modifier le contenu</a>";
} elseif ($role === 'Medecin') {
    echo "<a href='view_content.php'>Voir le contenu</a>";
} elseif ($role === 'Secretaire') {
    echo "<a>Vous etes bien connecté en tant que $role</a>";
    echo "<a href='pre.php'>preadmission</a>";
} elseif ($role === 'Unknown') {
    echo "<a>Vous n'avez pas de rôle attribué. Contactez l'administrateur.</a>";
} else {
    echo "<p>Vous n'avez pas de rôle actuellement : $role. Contactez l'administrateur.</p>";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord</title>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js" defer></script>
</head>
<body>
<!-- Bouton de déconnexion -->
<form action="deconnexion.php" method="POST">
    <button type="submit" class="btn btn-danger">Se déconnecter</button>
</form>
<div id="dashboard">
    <div class="module-container" id="modules-container">
        <!-- Les boutons seront insérés ici dynamiquement -->
    </div>
</div>

</body>
</html>
