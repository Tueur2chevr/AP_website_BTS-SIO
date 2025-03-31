<?php
require 'db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['recherche'])) {
    $recherche = "%" . $data['recherche'] . "%";

    // Recherche uniquement les médecins (id_role = 1)
    $stmt = $conn->prepare("SELECT nom, prenom FROM salarie WHERE id_role = 1 AND (nom LIKE ? OR prenom LIKE ?)");
    $stmt->bind_param("ss", $recherche, $recherche);
    $stmt->execute();
    $result = $stmt->get_result();

    $medecins = [];
    while ($row = $result->fetch_assoc()) {
        $medecins[] = ["nom" => $row["nom"], "prenom" => $row["prenom"]];
    }

    echo json_encode(["medecins" => $medecins]);
} else {
    echo json_encode(["medecins" => []]);
}
?>
