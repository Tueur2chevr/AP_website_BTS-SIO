// scripts.js

document.addEventListener('DOMContentLoaded', () => {
    // Récupérer le rôle de l'utilisateur depuis la session (ex: "Admin", "Infirmier", "Medecin")
    const role = getUserRoleFromSession(); // À remplacer par le rôle de l'utilisateur, stocké dans la session

    // Récupérer le conteneur de dashboard
    const dashboardContainer = document.getElementById('dashboard-container');

    // Définir les modules selon le rôle
    const modules = getModulesForRole(role);

    // Ajouter les modules au conteneur
    modules.forEach(module => {
        const moduleElement = document.createElement('div');
        moduleElement.classList.add('module');
        moduleElement.style.backgroundImage = `url(${module.image})`;

        const linkElement = document.createElement('a');
        linkElement.href = module.link;
        linkElement.innerText = module.title;

        moduleElement.appendChild(linkElement);
        dashboardContainer.appendChild(moduleElement);
    });

    // Fonction pour récupérer les modules selon le rôle
    function getModulesForRole(role) {
        const modules = [];

        if (role === "Admin") {
            modules.push(
                { title: "Gestion des utilisateurs", link: "/admin/users", image: "/images/admin1.jpg" },
                { title: "Paramètres système", link: "/admin/settings", image: "/images/admin2.jpg" }
            );
        } else if (role === "Infirmier") {
            modules.push(
                { title: "Suivi des patients", link: "/nurse/patients", image: "/images/nurse1.jpg" },
                { title: "Gestion des médicaments", link: "/nurse/medications", image: "/images/nurse2.jpg" }
            );
        } else if (role === "Medecin") {
            modules.push(
                { title: "Consultations", link: "/doctor/appointments", image: "/images/doctor1.jpg" },
                { title: "Historique des patients", link: "/doctor/history", image: "/images/doctor2.jpg" }
            );
        } else {
            modules.push(
                { title: "Page d'accueil", link: "/home", image: "/images/unknown1.jpg" }
            );
        }

        return modules;
    }

    function getUserRoleFromSession() {
        // En pratique, tu peux récupérer cela de la session PHP via AJAX ou des données déjà définies en JavaScript
        // Exemple ici, on suppose que le rôle est "Admin"
        var nom = '<?php echo $user[]; ?>';
        modules.push( {title: "nom", link: "/doctor/appointments", image: "/images/doctor1.jpg"})
        return nom; // A remplacer par la valeur réelle de la session
    }
});

//pre-admission
function chercherPatient() {
    const numSecu = document.getElementById("securite-sociale").value;

    fetch('recherche_patient.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ securite_sociale: numSecu })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById("nom").value = data.nom_naissance || "";
            document.getElementById("prenom").value = data.prenom || "";
            document.getElementById("email").value = data.mail || "";
            document.getElementById("adresse").value = data.adresse_postal || "";
            document.getElementById("telephone").value = data.telephone || "";
            document.getElementById("organisme_securite_sociale").value = data.organisme_securite_sociale || "";
            document.getElementById("caisse_assurance_maladie").value = data.caisse_assurance_maladie || "";
            document.getElementById("est_assure").checked = data.est_assure == "1";
            document.getElementById("est_ald").checked = data.est_ald == "1";
            document.getElementById("mutuelle_assurance").value = data.mutuelle_assurance || "";
            document.getElementById("numero_adhesion").value = data.numero_adhesion || "";
            document.getElementById("chambre_particuliere").checked = data.chambre_particuliere == "1";
            document.getElementById("hospitalisation_date").value = data.hospitalisation_date || "";
            document.getElementById("intervention_heure").value = data.intervention_heure || "";
            document.getElementById("nom_medecin").value = data.nom_medecin || "";

            // Personne à prévenir
            document.getElementById("personne_prevenir_nom").value = data.personne_prevenir_nom || "";
            document.getElementById("personne_prevenir_prenom").value = data.personne_prevenir_prenom || "";
            document.getElementById("personne_prevenir_telephone").value = data.personne_prevenir_telephone || "";
            document.getElementById("personne_prevenir_adresse").value = data.personne_prevenir_adresse || "";

            // Personne de confiance
            document.getElementById("personne_confiance_nom").value = data.personne_confiance_nom || "";
            document.getElementById("personne_confiance_prenom").value = data.personne_confiance_prenom || "";
            document.getElementById("personne_confiance_telephone").value = data.personne_confiance_telephone || "";
            document.getElementById("personne_confiance_adresse").value = data.personne_confiance_adresse || "";
        } else {
            alert("Aucun patient trouvé.");
        }
    })
    .catch(error => {
        console.error('Erreur lors de la recherche du patient :', error);
    });
}


document.getElementById("resetButton").addEventListener("click", function() {
    // Réinitialiser complètement le formulaire
    document.getElementById("preinscription-form").reset();
    document.getElementById("donnees-patient").style.display = "none";
});

document.addEventListener("DOMContentLoaded", function () {
    let today = new Date().toISOString().split("T")[0]; 
    document.getElementById("date_hospitalisation").setAttribute("min", today);
});

//
function rechercherMedecin() {
    let saisie = document.getElementById("nom_medecin").value;

    if (saisie.length >= 3) {
        fetch('recherche_medecin.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ recherche: saisie })
        })
        .then(response => response.json())
        .then(data => {
            let dataList = document.getElementById("liste_medecins");
            dataList.innerHTML = ""; // Réinitialise la liste

            data.medecins.forEach(medecin => {
                let option = document.createElement("option");
                option.value = medecin.nom + " " + medecin.prenom;
                dataList.appendChild(option);
            });
        })
        .catch(error => console.error("Erreur lors de la recherche :", error));
    }
}