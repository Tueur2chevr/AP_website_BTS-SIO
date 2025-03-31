<?php
//session_start();
require_once 'db.php'; // Fichier contenant la connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupération des données du formulaire
    $securite_sociale = $_POST['securite_sociale'] ?? '';
    $date_hospitalisation = $_POST['date_hospitalisation'] ?? '';
    $heure_hospitalisation = $_POST['heure_hospitalisation'] ?? '';
    $id_medecin = $_POST['id_medecin'] ?? '';
    $id_cate_hospitalisation = $_POST['id_cate_hospitalisation'] ?? '';
    $id_chambre = $_POST['id_chambre'] ?? '';
    
    // Vérification que tous les champs nécessaires sont remplis
    if (empty($securite_sociale) || empty($date_hospitalisation) || empty($heure_hospitalisation) || empty($id_medecin)) {
        echo json_encode(["status" => "error", "message" => "Tous les champs obligatoires doivent être remplis."]);
        exit;
    }
    
    try {
        // Insertion dans la table hospitalisation
        $stmt = $pdo->prepare("INSERT INTO hospitalisation (id_cate_hospitalisation, date_hospitalisation, heure_hospitalisation, id_medecin, num_patient, chambre) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$id_cate_hospitalisation, $date_hospitalisation, $heure_hospitalisation, $id_medecin, $securite_sociale, $id_chambre]);
        
        echo json_encode(["status" => "success", "message" => "Pré-admission enregistrée avec succès."]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Erreur lors de l'enregistrement : " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Méthode non autorisée."]);
}
