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
        let roleClass = 'default';
    
        if (role === "Admin") {
            roleClass = 'admin';
            modules.push(
                { title: "Gestion des utilisateurs", link: "/admin/users", image: "/images/admin1.jpg" },
                { title: "Paramètres système", link: "/admin/settings", image: "/images/admin2.jpg" }
            );
        } else if (role === "Infirmier") {
            roleClass = 'nurse';
            modules.push(
                { title: "Suivi des patients", link: "/nurse/patients", image: "/images/nurse1.jpg" },
                { title: "Gestion des médicaments", link: "/nurse/medications", image: "/images/nurse2.jpg" }
            );
        } else if (role === "Medecin") {
            roleClass = 'doctor';
            modules.push(
                { title: "Consultations", link: "/doctor/appointments", image: "/images/doctor1.jpg" },
                { title: "Historique des patients", link: "/doctor/history", image: "/images/doctor2.jpg" }
            );
        } else {
            modules.push(
                { title: "Page d'accueil", link: "/home", image: "/images/unknown1.jpg" }
            );
        }
    
        return { modules, roleClass };
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
            document.getElementById("nom_naissance").value = data.nom_naissance || "";
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
    // Réinitialiser tous les champs du formulaire
    document.getElementById("preinscription-form").reset();
    
    // Réinitialiser manuellement les cases à cocher car elles ne sont pas toujours bien reset
    document.getElementById("est_assure").checked = false;
    document.getElementById("est_ald").checked = false;
    document.getElementById("chambre_particuliere").checked = false;
    // Réinitialiser le champ de recherche médecin
    document.getElementById("liste_medecins").innerHTML = '';
    
    // Optionnel: Réinitialiser les champs de fichier (ils ne sont pas reset par .reset())
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.value = '';
    });
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

// Regarde si le patient est mineur et affiche le livret de famille si c'est le cas
function checkMinor() {
    const dateNaissance = document.getElementById('date_naissance').value;
    const livretFamilleContainer = document.getElementById('livret-famille-container');
    const livretFamilleInput = document.getElementById('livret_famille');
    
    if (!dateNaissance) {
        livretFamilleContainer.style.display = 'none';
        livretFamilleInput.removeAttribute('required');
        return;
    }

    const naissance = new Date(dateNaissance);
    const aujourdHui = new Date();
    
    // Calcul précis de l'âge
    let age = aujourdHui.getFullYear() - naissance.getFullYear();
    const mois = aujourdHui.getMonth() - naissance.getMonth();
    
    if (mois < 0 || (mois === 0 && aujourdHui.getDate() < naissance.getDate())) {
        age--;
    }

    if (age < 18) {
        livretFamilleContainer.style.display = 'block';
        livretFamilleInput.setAttribute('required', 'required');
    } else {
        livretFamilleContainer.style.display = 'none';
        livretFamilleInput.removeAttribute('required');
        livretFamilleInput.value = ''; // Effacer la valeur si existante
    }
}

// Initialisation au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    // Ajoutez l'écouteur d'événement pour la date de naissance
    document.getElementById('date_naissance').addEventListener('change', checkMinor);
    
    // Vérification initiale si la date est déjà remplie
    if (document.getElementById('date_naissance').value) {
        checkMinor();
    }
    
    // Autres initialisations si nécessaire
    const buttons = document.querySelectorAll('.civilite-button');
    const hiddenInput = document.getElementById('civilite');
    
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            // Retire la classe active de tous les boutons
            buttons.forEach(btn => btn.classList.remove('active'));
            
            // Ajoute la classe active au bouton cliqué
            this.classList.add('active');
            
            // Met à jour la valeur cachée
            hiddenInput.value = this.dataset.value;
            
            // Animation de feedback
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                this.style.transform = '';
            }, 100);
        });
    });
});