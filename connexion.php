<?php
$dsn = 'mysql:host=localhost; dbname=hopitalap;charset=utf8';
$username = 'Vicdev';
$password = 'V$cD3v';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM salarie LEFT JOIN role ON salarie.id_role = role.id_role WHERE salarie.username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo "<p style='color: red;'>Utilisateur introuvable.</p>";
            exit;  
        } else {
            session_start();
            if (password_verify($password, $user['mdp'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['libelle'];
                header("Location: dashboard.php");
                exit;
            }
        }    
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="login-container">
        <form class="login-form" method="POST" action="connexion.php">
            <h2>Connexion</h2>

            <div class="input-group">
                <label for="username">Nom d'utilisateur :</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="input-group">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="input-group">
                <button type="submit">Se connecter</button>
            </div>
        </form>
    </div>

</body>
</html>
