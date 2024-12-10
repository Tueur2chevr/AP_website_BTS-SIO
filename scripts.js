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
        return nom; // A remplacer par la valeur réelle de la session
    }
});
