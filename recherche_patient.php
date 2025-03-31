<?php
require 'db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['securite_sociale'])) {
    $numSecu = $data['securite_sociale'];

    $stmt = $conn->prepare("SELECT * FROM patients WHERE securite_sociale = ?");
    $stmt->bind_param("s", $numSecu);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $patient = $result->fetch_assoc();

        echo json_encode([
            "success" => true,
            "nom_naissance" => $patient["nom_naissance"],
            "prenom" => $patient["prenom"],
            "mail" => $patient["mail"],
            "adresse_postal" => $patient["adresse_postal"],
            "telephone" => $patient["telephone"],
            "organisme_securite_sociale" => $patient["organisme_securite_sociale"],
            "caisse_assurance_maladie" => $patient["caisse_assurance_maladie"],
            "est_assure" => $patient["est_assure"],
            "est_ald" => $patient["est_ald"],
            "mutuelle_assurance" => $patient["mutuelle_assurance"],
            "numero_adhesion" => $patient["numero_adhesion"],
            "chambre_particuliere" => $patient["chambre_particuliere"],
            "hospitalisation_date" => $patient["hospitalisation_date"],
            "intervention_heure" => $patient["intervention_heure"],
            "nom_medecin" => $patient["nom_medecin"],
            "personne_prevenir_nom" => $patient["personne_prevenir_nom"],
            "personne_prevenir_prenom" => $patient["personne_prevenir_prenom"],
            "personne_prevenir_telephone" => $patient["personne_prevenir_telephone"],
            "personne_prevenir_adresse" => $patient["personne_prevenir_adresse"],
            "personne_confiance_nom" => $patient["personne_confiance_nom"],
            "personne_confiance_prenom" => $patient["personne_confiance_prenom"],
            "personne_confiance_telephone" => $patient["personne_confiance_telephone"],
            "personne_confiance_adresse" => $patient["personne_confiance_adresse"]
        ]);
    } else {
        echo json_encode(["success" => false]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Requête invalide"]);
}
?>
