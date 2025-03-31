<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Préinscription</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Formulaire de Préinscription -->
    <div id="formulaire">
        <h1>Formulaire de Préinscription</h1>
        <div>
            <button type="button" class="btn btn-danger" id="resetButton">Reset Form</button>
        </div>
        <form id="preinscription-form" method="POST">
            <!-- Champ pour le numéro de sécurité sociale -->
            <label for="securite-sociale">Numéro de sécurité sociale :</label>
            <input type="text" id="securite-sociale" name="securite_sociale" required>
            <button type="button" onclick="chercherPatient()">Chercher</button>

            <!-- Div qui va contenir les données du patient (visible après recherche) -->
            <div id="donnees-patient">
                <h2>Informations du Patient</h2>
                <div>
                    <label for="nom">Nom :</label>
                    <input type="text" id="nom" name="nom" >
                </div>
                <div>
                    <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom" name="prenom" >
                </div>
                <div>
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="mail" >
                </div>
                <div>
                    <label for="adresse">Adresse :</label>
                    <input type="text" id="adresse" name="adresse_postal" >
                </div>
                <div>
                    <label for="telephone">Téléphone :</label>
                    <input type="text" id="telephone" name="telephone" >
                </div>

                <!-- Pré-admission -->
                <h2>Informations de Pré-Admission</h2>
                <div>
                    <label for="organisme_securite_sociale">Organisme de sécurité sociale :</label>
                    <input type="text" id="organisme_securite_sociale" name="organisme_securite_sociale">
                </div>
                <div>
                    <label for="caisse_assurance_maladie">Nom de la caisse d'assurance maladie :</label>
                    <input type="text" id="caisse_assurance_maladie" name="caisse_assurance_maladie">
                </div>
                <div>
                    <label for="est_assure">Le patient est-il l'assuré ?</label>
                    <input type="checkbox" id="est_assure" name="est_assure">
                </div>
                <div>
                    <label for="est_ald">Le patient est-il en ALD ?</label>
                    <input type="checkbox" id="est_ald" name="est_ald">
                </div>
                <div>
                    <label for="mutuelle_assurance">Nom de la mutuelle ou de l'assurance :</label>
                    <input type="text" id="mutuelle_assurance" name="mutuelle_assurance">
                </div>
                <div>
                    <label for="numero_adhesion">Numéro d'adhérent :</label>
                    <input type="text" id="numero_adhesion" name="numero_adhesion">
                </div>
                <div>
                    <label for="chambre_particuliere">Chambre particulière :</label>
                    <input type="checkbox" id="chambre_particuliere" name="chambre_particuliere">
                </div>

                <!-- Date et heure de l'hospitalisation -->
                <div>
                    <label for="hospitalisation_date">Date de l'hospitalisation :</label>
                    <input type="date" id="hospitalisation_date" name="hospitalisation_date">
                </div>
                <div>
                    <label for="intervention_heure">Heure de l'intervention :</label>
                    <input type="time" id="intervention_heure" name="intervention_heure">
                </div>

                <!-- Nom du médecin -->
                <div>
                    <label for="nom_medecin">Nom du médecin :</label>
                    <input type="text" id="nom_medecin" name="nom_medecin" oninput="rechercherMedecin()" list="liste_medecins">
                    <datalist id="liste_medecins"></datalist>
                </div>
            </div>

            <!-- Personne à prévenir -->
            <div id="personne-a-prevenir">
                <h2>Personne à prévenir</h2>
                <div>
                    <label for="personne_prevenir_nom">Nom :</label>
                    <input type="text" id="personne_prevenir_nom" name="personne_prevenir_nom">
                </div>
                <div>
                    <label for="personne_prevenir_prenom">Prénom :</label>
                    <input type="text" id="personne_prevenir_prenom" name="personne_prevenir_prenom">
                </div>
                <div>
                    <label for="personne_prevenir_telephone">Téléphone :</label>
                    <input type="text" id="personne_prevenir_telephone" name="personne_prevenir_telephone">
                </div>
                <div>
                    <label for="personne_prevenir_adresse">Adresse :</label>
                    <input type="text" id="personne_prevenir_adresse" name="personne_prevenir_adresse">
                </div>
            </div>

            <!-- Personne de confiance -->
            <div id="personne-de-confiance">
                <h2>Personne de confiance</h2>
                <div>
                    <label for="personne_confiance_nom">Nom :</label>
                    <input type="text" id="personne_confiance_nom" name="personne_confiance_nom">
                </div>
                <div>
                    <label for="personne_confiance_prenom">Prénom :</label>
                    <input type="text" id="personne_confiance_prenom" name="personne_confiance_prenom">
                </div>
                <div>
                    <label for="personne_confiance_telephone">Téléphone :</label>
                    <input type="text" id="personne_confiance_telephone" name="personne_confiance_telephone">
                </div>
                <div>
                    <label for="personne_confiance_adresse">Adresse :</label>
                    <input type="text" id="personne_confiance_adresse" name="personne_confiance_adresse">
                </div>
            </div>
            <!-- Téléchargement des documents -->
                <h2>Documents à fournir</h2>

            <div>
                <label for="carte_identite_recto">Carte d'identité (Recto) :</label>
                <input type="file" id="carte_identite_recto" name="carte_identite_recto" accept="image/*,.pdf">
            </div>
            <div>
                <label for="carte_identite_verso">Carte d'identité (Verso) :</label>
                <input type="file" id="carte_identite_verso" name="carte_identite_verso" accept="image/*,.pdf">
            </div>
            <div>
                <label for="carte_vitale">Carte Vitale :</label>
                <input type="file" id="carte_vitale" name="carte_vitale" accept="image/*,.pdf">
            </div>
            <div>
                <label for="carte_mutuelle">Carte de mutuelle :</label>
                <input type="file" id="carte_mutuelle" name="carte_mutuelle" accept="image/*,.pdf">
            </div>
            <div>
                <label for="livret_famille">Livret de famille (enfants mineurs) :</label>
                <input type="file" id="livret_famille" name="livret_famille" accept="image/*,.pdf">
            </div>

            <div>
                <button type="submit">Valider l'inscription</button>
            </div>
        </form>
    </div>

    <script src="scripts.js"></script>
</body>
</html>
