<?php
// db.php - Connexion à la base de données

// Paramètres de connexion à la base de données
$host = '127.0.0.1';  // Hôte de la base de données
$dbname = 'hopitalap';  // Nom de la base de données
$username = 'Vicdev';  // Nom d'utilisateur MySQL (si tu utilises root, sinon change-le)
$password = 'V$cD3v';  // Mot de passe MySQL (modifie-le selon tes configurations)

// Essaie de se connecter à la base de données
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    // Paramètres supplémentaires pour assurer une gestion des erreurs propre
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // En cas d'erreur de connexion, on affiche l'erreur
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
