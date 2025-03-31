<?php
session_start();
require 'db.php'; // Inclure le fichier de connexion PDO

// Vérifier que l'utilisateur est autorisé à ajouter un salarié
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: dashboard.php");
    exit;
}

$message = "";

// Récupération dynamique des services
$services = [];
try {
    $stmt = $pdo->query("SELECT id_service, libelle FROM service");
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $message = "❌ Erreur lors de la récupération des services : " . $e->getMessage();
}

// Récupération dynamique des rôles
$roles = [];
try {
    $stmt = $pdo->query("SELECT id_role, libelle FROM role");
    $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $message = "❌ Erreur lors de la récupération des rôles : " . $e->getMessage();
}

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $id_service = intval($_POST['id_service']);
    $id_role = intval($_POST['id_role']);
    $username = generateUsername($nom, $prenom); // Génération automatique
    $mdp = password_hash($_POST['mdp'], PASSWORD_BCRYPT);

    try {
        // Vérifier si le salarié existe déjà avec le même nom et prénom
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM salarie WHERE nom = ? AND prenom = ?");
        $stmt->execute([$nom, $prenom]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            $message = "⚠️ Un salarié avec ce nom et prénom existe déjà.";
        } else {
            // Insérer le salarié si aucun doublon n'est trouvé
            $stmt = $pdo->prepare("INSERT INTO salarie (nom, prenom, mdp, id_role, id_service, username) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nom, $prenom, $mdp, $id_role, $id_service, $username]);
            $message = "✅ Salarié ajouté avec succès !";
        }
    } catch (PDOException $e) {
        $message = "❌ Erreur lors de l'ajout du salarié : " . $e->getMessage();
    }
}

// Fonction pour générer le username automatiquement
function generateUsername($nom, $prenom) {
    return strtolower($prenom) . '.' . strtolower($nom);
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Salarié</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="form-container">
        <h1>Ajouter un Salarié</h1>

        <?php if (!empty($message)) { 
            $class = strpos($message, "❌") !== false ? "error" : "success";
            echo "<p class='$class'>$message</p>"; 
        } ?>

        <form method="POST">
            <label>Nom :</label>
            <input type="text" name="nom" required>

            <label>Prénom :</label>
            <input type="text" name="prenom" required>

            <label>Rôle :</label>
            <select name="id_role" required>
                <option value="">Sélectionner un rôle</option>
                <?php foreach ($roles as $role): ?>
                    <option value="<?= $role['id_role']; ?>"><?= htmlspecialchars($role['libelle']); ?></option>
                <?php endforeach; ?>
            </select>

            <label>Service :</label>
            <select name="id_service" required>
                <option value="">Sélectionner un service</option>
                <?php foreach ($services as $service): ?>
                    <option value="<?= $service['id_service']; ?>"><?= htmlspecialchars($service['libelle']); ?></option>
                <?php endforeach; ?>
            </select>

            <label>Mot de passe :</label>
            <input type="password" name="mdp" required>

            <button type="submit">Ajouter</button>
        </form>

        <a href="dashboard.php">Retour au Dashboard</a>
    </div>

</body>
</html>
