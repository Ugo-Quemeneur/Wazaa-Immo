-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 12 fév. 2025 à 16:46
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `wazaa`
--
CREATE DATABASE IF NOT EXISTS `wazaa` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `wazaa`;

-- --------------------------------------------------------

--
-- Structure de la table `waz_annonce`
--

DROP TABLE IF EXISTS `waz_annonce`;
CREATE TABLE `waz_annonce` (
  `Reference_Annonce` int(11) NOT NULL,
  `Titre_Annonce` varchar(50) DEFAULT NULL,
  `Description_Annonce` text NOT NULL,
  `Date_Ajout_Annonce` date NOT NULL,
  `Date_Modification_Annonce` datetime NOT NULL,
  `Prix_Annonce` decimal(10,2) NOT NULL,
  `Id_Option` int(11) NOT NULL,
  `Id_Photo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `waz_bien`
--

DROP TABLE IF EXISTS `waz_bien`;
CREATE TABLE `waz_bien` (
  `Id_Bien` int(11) NOT NULL,
  `Surface_Habitable_Bien` varchar(50) DEFAULT NULL,
  `Surface_Totale_Bien` varchar(50) NOT NULL,
  `Nombre_Pieces_Bien` varchar(6) DEFAULT NULL,
  `Localisation_Bien` varchar(100) NOT NULL,
  `Diagnostic_Bien` varchar(1) DEFAULT NULL,
  `Reference_Annonce` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `waz_option`
--

DROP TABLE IF EXISTS `waz_option`;
CREATE TABLE `waz_option` (
  `Id_Option` int(11) NOT NULL,
  `Libelle_Option` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `waz_photo`
--

DROP TABLE IF EXISTS `waz_photo`;
CREATE TABLE `waz_photo` (
  `Id_Photo` int(11) NOT NULL,
  `Url_Photo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `waz_type_bien`
--

DROP TABLE IF EXISTS `waz_type_bien`;
CREATE TABLE `waz_type_bien` (
  `Id_Type_Bien` int(11) NOT NULL,
  `Libelle_Type_Bien` varchar(50) DEFAULT NULL,
  `Id_Bien` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `waz_type_offre`
--

DROP TABLE IF EXISTS `waz_type_offre`;
CREATE TABLE `waz_type_offre` (
  `Id_Type_Offre` int(11) NOT NULL,
  `Libelle_Type_Offre` varchar(50) DEFAULT NULL,
  `Reference_Annonce` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `waz_type_utilisateur`
--

DROP TABLE IF EXISTS `waz_type_utilisateur`;
CREATE TABLE `waz_type_utilisateur` (
  `Id_Type_Utilisateur` int(11) NOT NULL,
  `Libelle_Utilisateur` varchar(50) NOT NULL,
  `Id_Utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `waz_utilisateur`
--

DROP TABLE IF EXISTS `waz_utilisateur`;
CREATE TABLE `waz_utilisateur` (
  `Id_Utilisateur` int(11) NOT NULL,
  `Nom_Utilisateur` varchar(50) DEFAULT NULL,
  `Prenom_Utilisateur` varchar(50) DEFAULT NULL,
  `Mot_De_Passe_Utilisateur` varchar(50) NOT NULL,
  `Reference_Annonce` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `waz_annonce`
--
ALTER TABLE `waz_annonce`
  ADD PRIMARY KEY (`Reference_Annonce`),
  ADD KEY `Id_Option` (`Id_Option`),
  ADD KEY `Id_Photo` (`Id_Photo`);

--
-- Index pour la table `waz_bien`
--
ALTER TABLE `waz_bien`
  ADD PRIMARY KEY (`Id_Bien`),
  ADD UNIQUE KEY `Reference_Annonce` (`Reference_Annonce`);

--
-- Index pour la table `waz_option`
--
ALTER TABLE `waz_option`
  ADD PRIMARY KEY (`Id_Option`);

--
-- Index pour la table `waz_photo`
--
ALTER TABLE `waz_photo`
  ADD PRIMARY KEY (`Id_Photo`);

--
-- Index pour la table `waz_type_bien`
--
ALTER TABLE `waz_type_bien`
  ADD PRIMARY KEY (`Id_Type_Bien`),
  ADD KEY `Id_Bien` (`Id_Bien`);

--
-- Index pour la table `waz_type_offre`
--
ALTER TABLE `waz_type_offre`
  ADD PRIMARY KEY (`Id_Type_Offre`),
  ADD KEY `Reference_Annonce` (`Reference_Annonce`);

--
-- Index pour la table `waz_type_utilisateur`
--
ALTER TABLE `waz_type_utilisateur`
  ADD PRIMARY KEY (`Id_Type_Utilisateur`),
  ADD KEY `Id_Utilisateur` (`Id_Utilisateur`);

--
-- Index pour la table `waz_utilisateur`
--
ALTER TABLE `waz_utilisateur`
  ADD PRIMARY KEY (`Id_Utilisateur`),
  ADD KEY `Reference_Annonce` (`Reference_Annonce`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `waz_annonce`
--
ALTER TABLE `waz_annonce`
  MODIFY `Reference_Annonce` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `waz_bien`
--
ALTER TABLE `waz_bien`
  MODIFY `Id_Bien` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `waz_option`
--
ALTER TABLE `waz_option`
  MODIFY `Id_Option` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `waz_photo`
--
ALTER TABLE `waz_photo`
  MODIFY `Id_Photo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `waz_type_bien`
--
ALTER TABLE `waz_type_bien`
  MODIFY `Id_Type_Bien` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `waz_type_offre`
--
ALTER TABLE `waz_type_offre`
  MODIFY `Id_Type_Offre` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `waz_type_utilisateur`
--
ALTER TABLE `waz_type_utilisateur`
  MODIFY `Id_Type_Utilisateur` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `waz_utilisateur`
--
ALTER TABLE `waz_utilisateur`
  MODIFY `Id_Utilisateur` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `waz_annonce`
--
ALTER TABLE `waz_annonce`
  ADD CONSTRAINT `waz_annonce_ibfk_1` FOREIGN KEY (`Id_Option`) REFERENCES `waz_option` (`Id_Option`),
  ADD CONSTRAINT `waz_annonce_ibfk_2` FOREIGN KEY (`Id_Photo`) REFERENCES `waz_photo` (`Id_Photo`);

--
-- Contraintes pour la table `waz_bien`
--
ALTER TABLE `waz_bien`
  ADD CONSTRAINT `waz_bien_ibfk_1` FOREIGN KEY (`Reference_Annonce`) REFERENCES `waz_annonce` (`Reference_Annonce`);

--
-- Contraintes pour la table `waz_type_bien`
--
ALTER TABLE `waz_type_bien`
  ADD CONSTRAINT `waz_type_bien_ibfk_1` FOREIGN KEY (`Id_Bien`) REFERENCES `waz_bien` (`Id_Bien`);

--
-- Contraintes pour la table `waz_type_offre`
--
ALTER TABLE `waz_type_offre`
  ADD CONSTRAINT `waz_type_offre_ibfk_1` FOREIGN KEY (`Reference_Annonce`) REFERENCES `waz_annonce` (`Reference_Annonce`);

--
-- Contraintes pour la table `waz_type_utilisateur`
--
ALTER TABLE `waz_type_utilisateur`
  ADD CONSTRAINT `waz_type_utilisateur_ibfk_1` FOREIGN KEY (`Id_Utilisateur`) REFERENCES `waz_utilisateur` (`Id_Utilisateur`);

--
-- Contraintes pour la table `waz_utilisateur`
--
ALTER TABLE `waz_utilisateur`
  ADD CONSTRAINT `waz_utilisateur_ibfk_1` FOREIGN KEY (`Reference_Annonce`) REFERENCES `waz_annonce` (`Reference_Annonce`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
