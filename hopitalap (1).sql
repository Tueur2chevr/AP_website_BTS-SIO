-- phpMyAdmin SQL Dump
-- version 5.2.1deb1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : lun. 10 mars 2025 à 10:54
-- Version du serveur : 10.11.6-MariaDB-0+deb12u1
-- Version de PHP : 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `hopitalap`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie_hospitalisation`
--

CREATE TABLE `categorie_hospitalisation` (
  `id_hospitalisation` int(11) NOT NULL,
  `cate` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `categorie_hospitalisation`
--

INSERT INTO `categorie_hospitalisation` (`id_hospitalisation`, `cate`) VALUES
(1, 'Ambulatoire chirurgie'),
(2, 'Hospitalisation');

-- --------------------------------------------------------

--
-- Structure de la table `chambre`
--

CREATE TABLE `chambre` (
  `id_chambre` int(11) NOT NULL,
  `type_chambre` varchar(50) DEFAULT NULL,
  `numero_chambre` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `chambre`
--

INSERT INTO `chambre` (`id_chambre`, `type_chambre`, `numero_chambre`) VALUES
(101, 'individuelle', 12),
(102, 'double', 8);

-- --------------------------------------------------------

--
-- Structure de la table `documents`
--

CREATE TABLE `documents` (
  `id_document` int(11) NOT NULL,
  `carte_vitale_recto` text DEFAULT NULL,
  `carte_vitale_verso` text DEFAULT NULL,
  `carte_identite` text DEFAULT NULL,
  `carte_mutuelle` text DEFAULT NULL,
  `livret_famille` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `documents`
--

INSERT INTO `documents` (`id_document`, `carte_vitale_recto`, `carte_vitale_verso`, `carte_identite`, `carte_mutuelle`, `livret_famille`) VALUES
(1, 'Image recto', 'Image verso', 'Image ID', 'Image mutuelle', 'Image livret');

-- --------------------------------------------------------

--
-- Structure de la table `hospitalisation`
--

CREATE TABLE `hospitalisation` (
  `id_hospitalisation` int(11) NOT NULL,
  `id_cate_hospitalisation` int(11) DEFAULT NULL,
  `date_hospitalisation` date DEFAULT NULL,
  `heure_hospitalisation` time DEFAULT NULL,
  `id_medecin` int(11) DEFAULT NULL,
  `num_patient` bigint(20) DEFAULT NULL,
  `chambre` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `hospitalisation`
--

INSERT INTO `hospitalisation` (`id_hospitalisation`, `id_cate_hospitalisation`, `date_hospitalisation`, `heure_hospitalisation`, `id_medecin`, `num_patient`, `chambre`) VALUES
(1, 1, '2024-11-18', '14:00:00', 101, 1234567890123, 'individuelle');

-- --------------------------------------------------------

--
-- Structure de la table `patient`
--

CREATE TABLE `patient` (
  `securite_sociale` bigint(20) NOT NULL,
  `organisation_secu` varchar(35) DEFAULT NULL,
  `assure` tinyint(1) DEFAULT NULL,
  `ald` tinyint(1) DEFAULT NULL,
  `nom_mutuelle` varchar(35) DEFAULT NULL,
  `num_adherent` int(11) DEFAULT NULL,
  `civilite` enum('homme','femme') DEFAULT NULL,
  `nom_naissance` varchar(50) DEFAULT NULL,
  `nom_epouse` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `adresse_postal` varchar(50) DEFAULT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `code_postal` varchar(10) DEFAULT NULL,
  `mail` varchar(50) DEFAULT NULL,
  `telephone` varchar(15) DEFAULT NULL,
  `personne_prevenir` int(11) DEFAULT NULL,
  `personne_confiance` int(11) DEFAULT NULL,
  `id_doc_perso` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `patient`
--

INSERT INTO `patient` (`securite_sociale`, `organisation_secu`, `assure`, `ald`, `nom_mutuelle`, `num_adherent`, `civilite`, `nom_naissance`, `nom_epouse`, `prenom`, `date_naissance`, `adresse_postal`, `ville`, `code_postal`, `mail`, `telephone`, `personne_prevenir`, `personne_confiance`, `id_doc_perso`) VALUES
(1234567890123, 'CPAM', 1, 0, 'Harmonie Mutuelle', 456789, 'homme', 'Doe', '', 'John', '1980-01-01', '12 rue des Lilas', 'Paris', '75000', 'john.doe@example.com', '+33123456789', 1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `personne_confiance`
--

CREATE TABLE `personne_confiance` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `telephone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `personne_confiance`
--

INSERT INTO `personne_confiance` (`id`, `nom`, `prenom`, `telephone`) VALUES
(1, 'Brown', 'Charlie', '+33612345678');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id_role` int(11) NOT NULL,
  `libelle` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id_role`, `libelle`) VALUES
(1, 'Medecin'),
(2, 'Infirmier'),
(3, 'Unknown'),
(4, 'Admin'),
(5, 'Secretaire');

-- --------------------------------------------------------

--
-- Structure de la table `salarie`
--

CREATE TABLE `salarie` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `mdp` text DEFAULT NULL,
  `id_role` int(11) DEFAULT NULL,
  `id_service` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `salarie`
--

INSERT INTO `salarie` (`id`, `nom`, `prenom`, `mdp`, `id_role`, `id_service`, `username`) VALUES
(1, 'Smith', 'Alice', '$2y$10$QQRqlpxn0i2D.1NTWBPie.FjYNCwl4snvb8cgPUZGYpqrao.mVL5m', 5, 1, 'Smith_Alice');

--
-- Déclencheurs `salarie`
--
DELIMITER $$
CREATE TRIGGER `username_insert` BEFORE INSERT ON `salarie` FOR EACH ROW BEGIN
  SET NEW.username = CONCAT(NEW.nom, '_', NEW.prenom);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `username_update` BEFORE UPDATE ON `salarie` FOR EACH ROW BEGIN
  SET NEW.username = CONCAT(NEW.nom, '_', NEW.prenom);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `service`
--

CREATE TABLE `service` (
  `id_service` int(11) NOT NULL,
  `libelle` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `service`
--

INSERT INTO `service` (`id_service`, `libelle`) VALUES
(1, 'Cardiologie'),
(2, 'Chirurgie');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categorie_hospitalisation`
--
ALTER TABLE `categorie_hospitalisation`
  ADD PRIMARY KEY (`id_hospitalisation`);

--
-- Index pour la table `chambre`
--
ALTER TABLE `chambre`
  ADD PRIMARY KEY (`id_chambre`);

--
-- Index pour la table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id_document`);

--
-- Index pour la table `hospitalisation`
--
ALTER TABLE `hospitalisation`
  ADD PRIMARY KEY (`id_hospitalisation`),
  ADD KEY `id_cate_hospitalisation` (`id_cate_hospitalisation`);

--
-- Index pour la table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`securite_sociale`);

--
-- Index pour la table `personne_confiance`
--
ALTER TABLE `personne_confiance`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Index pour la table `salarie`
--
ALTER TABLE `salarie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_role` (`id_role`),
  ADD KEY `id_service` (`id_service`);

--
-- Index pour la table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id_service`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
