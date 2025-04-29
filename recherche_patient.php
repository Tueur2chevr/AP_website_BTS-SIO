<?php
require 'db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['securite_sociale'])) {
    $numSecu = $data['securite_sociale'];

    $stmt = $pdo->prepare("SELECT * FROM patient JOIN personne_confiance ON patient.personne_confiance = personne_confiance.id JOIN documents ON patient.id_doc_perso = documents.id_document HAVING securite_sociale = ?;");
    $stmt->execute([$numSecu]);
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($patient) {
        echo json_encode([
            "success" => true,
            "civilite" => $patient["civilite"],
            "nom_naissance" => $patient["nom_naissance"],
            "nom_epoux" => $patient["nom_epouse"],
            "prenom" => $patient["prenom"],
            "date_naissance" => $patient["date_naissance"],
            "mail" => $patient["mail"],
            "adresse_postal" => $patient["adresse_postal"],
            "ville" => $patient["ville"],
            "code_postal" => $patient["code_postal"],
            "telephone" => $patient["telephone"],
            "organisme_securite_sociale" => $patient["organisation_secu"],
            "est_assure" => $patient["assure"],
            "est_ald" => $patient["ald"],
            "mutuelle_assurance" => $patient["nom_mutuelle"],
            "numero_adhesion" => $patient["num_adherent"]
        ]);
    } else {
        echo json_encode(["success" => false]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Requête invalide"]);
}
?>