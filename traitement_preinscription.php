<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    function uploadFile($file, $folder) {
        $targetDir = "uploads/$folder/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $fileName = basename($file["name"]);
        $targetFilePath = $targetDir . $fileName;
        if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
            return $targetFilePath;
        }
        return null;
    }

    $carte_identite_recto = uploadFile($_FILES['carte_identite_recto'], "identites");
    $carte_identite_verso = uploadFile($_FILES['carte_identite_verso'], "identites");
    $carte_vitale = uploadFile($_FILES['carte_vitale'], "cartes");
    $carte_mutuelle = uploadFile($_FILES['carte_mutuelle'], "mutuelles");
    $livret_famille = uploadFile($_FILES['livret_famille'], "livrets");

    $sql = "INSERT INTO preadmissions (securite_sociale, nom_naissance, prenom, email, adresse, telephone,
                carte_identite_recto, carte_identite_verso, carte_vitale, carte_mutuelle, livret_famille)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssss",
        $_POST['securite_sociale'], $_POST['nom_naissance'], $_POST['prenom'], $_POST['email'], $_POST['adresse'], $_POST['telephone'],
        $carte_identite_recto, $carte_identite_verso, $carte_vitale, $carte_mutuelle, $livret_famille
    );

    if ($stmt->execute()) {
        echo "Inscription réussie !";
    } else {
        echo "Erreur : " . $stmt->error;
    }
}
?>
