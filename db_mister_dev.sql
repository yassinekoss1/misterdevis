-- phpMyAdmin SQL Dump
-- version 4.7.6
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Dec 25, 2017 at 03:00 PM
-- Server version: 8.0.3-rc-log
-- PHP Version: 7.1.9

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_mister_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `activite`
--

DROP TABLE IF EXISTS `activite`;
CREATE TABLE `activite` (
  `ID_ACTIVITE` bigint(20) NOT NULL,
  `LIBELLE` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `activite`
--

INSERT INTO `activite` (`ID_ACTIVITE`, `LIBELLE`) VALUES
(1, 'PISCINE'),
(2, 'CHAUFFAGE'),
(3, 'FENETRE'),
(4, 'CUISINE'),
(5, 'SALLE BAIN'),
(6, 'SAUNA HAMMAM'),
(7, 'SPA');

-- --------------------------------------------------------

--
-- Table structure for table `artisan`
--

DROP TABLE IF EXISTS `artisan`;
CREATE TABLE `artisan` (
  `ID_ARTISAN` bigint(20) NOT NULL,
  `CODE_ARTISAN` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `NOM_ARTISAN` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `PRENOM_ARTISAN` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `RAISON_SOCIALE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EMAIL_ARTISAN` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `TELEPHONE_FIXE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TELEPHONE_PORTABLE` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `FAX` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `RCS` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VILLE` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `SIRET` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CODE_NAF` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `HORAIRERDV` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `ADRESSE` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `ADRESSE2` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CODE_POSTAL` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `DESCRIPTION` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `QUALIFICATION` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chantier`
--

DROP TABLE IF EXISTS `chantier`;
CREATE TABLE `chantier` (
  `ID_CHANTIER` bigint(20) NOT NULL,
  `ID_ZONE` bigint(20) NOT NULL,
  `ADRESSE` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `ADRESSE2` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VILLE` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `CODE_POSTAL` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `chantier`
--

INSERT INTO `chantier` (`ID_CHANTIER`, `ID_ZONE`, `ADRESSE`, `ADRESSE2`, `VILLE`, `CODE_POSTAL`) VALUES
(22, 1, 'QUARTIER DECHAMPS N°253', 'SYBA', 'PARIS', '75004'),
(23, 1, 'Winterfell', 'The north', 'Westros', '66000'),
(24, 2, '433 STEWART STREET', '', 'INDIANAPOLIS', '47715'),
(25, 2, '433 STEWART STREET', '', 'INDIANAPOLIS', '47715'),
(26, 2, '2nd street', 'Derry', 'Maine', '5909'),
(27, 1, 'Bushwick Brooklyn, NY', '', 'Brooklyn', '11207'),
(28, 2, '22 1b baker street', '', 'london', '2049'),
(29, 2, 'Dragonstone', '', 'Westros', '2988'),
(37, 2, '433 stewart street', 'kjkk', 'indianapolis', '47715'),
(39, 2, '433 stewart street', '', 'indianapolis', '47715'),
(45, 2, '433 stewart street', '', 'boujdour', '71000'),
(46, 2, '198 lot taalim', '', 'boujdour', '71000'),
(47, 2, '433 stewart street', 'adresse 2 here', 'marrakech', '40000'),
(48, 2, '433 stewart street', '', 'indianapolis', '47715');

-- --------------------------------------------------------

--
-- Table structure for table `demande_devis`
--

DROP TABLE IF EXISTS `demande_devis`;
CREATE TABLE `demande_devis` (
  `ID_DEMANDE` bigint(20) NOT NULL,
  `ID_PARTICULIER` bigint(20) NOT NULL,
  `ID_ACTIVITE` bigint(20) NOT NULL,
  `ID_CHANTIER` bigint(20) DEFAULT NULL,
  `ID_USER` bigint(20) DEFAULT NULL,
  `TITRE_DEMANDE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DELAI_SOUHAITE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DESCRIPTION` text COLLATE utf8_unicode_ci,
  `TYPE_DEMANDEUR` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TYPE_PROPRIETE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TYPE_BATIMENT` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `BUDGET_APPROXIMATIF` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `FINANCEMENT_PROJET` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `OBJECTIF_DEMANDE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PRESTATION_SOUHAITE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `INDICATION_COMPLEMENTAIRE` text COLLATE utf8_unicode_ci,
  `QUALIFICATION` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PRIX_MISE_EN_LIGNE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PRIX_PROMO` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PUBLIER_EN_LIGNE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CHEMIN_PDF` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DATE_CREATION` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DATE_PUBLICATION` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `demande_devis`
--

INSERT INTO `demande_devis` (`ID_DEMANDE`, `ID_PARTICULIER`, `ID_ACTIVITE`, `ID_CHANTIER`, `ID_USER`, `TITRE_DEMANDE`, `DELAI_SOUHAITE`, `DESCRIPTION`, `TYPE_DEMANDEUR`, `TYPE_PROPRIETE`, `TYPE_BATIMENT`, `BUDGET_APPROXIMATIF`, `FINANCEMENT_PROJET`, `OBJECTIF_DEMANDE`, `PRESTATION_SOUHAITE`, `INDICATION_COMPLEMENTAIRE`, `QUALIFICATION`, `PRIX_MISE_EN_LIGNE`, `PRIX_PROMO`, `PUBLIER_EN_LIGNE`, `CHEMIN_PDF`, `DATE_CREATION`, `DATE_PUBLICATION`) VALUES
(8, 2, 2, 28, 2, 'installation chauffage', 'Dans moins d\'un mois', 'lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet .', 'Autre', 'Administrateur', 'Immeuble', '1000', 'Crédit Obtenu', 'Obtenir des devis et trouver une entreprise', 'Pose Uniquement', 'lorem ipsum dolor sit amet  lorem ipsum dolor sit amet  lorem ipsum dolor sit amet  lorem ipsum dolor sit amet  lorem ipsum dolor sit amet  lorem ipsum dolor sit amet  lorem ipsum dolor sit amet  lorem ipsum dolor sit amet  lorem ipsum dolor sit amet  lorem ipsum dolor sit amet  lorem ipsum dolor sit amet .', 'Occupé', '1000', '3000', '1', NULL, '2017-12-23 18:44:19', '2017-12-24 21:33:47'),
(9, 1, 3, 39, 2, 'Reparation de fenetres', 'Dans moins d\'un mois', 'lorem ipsum dolor sit amit', 'Industriel', 'Futur Propriétaire', 'Bureau', '5000', 'Comptant', 'Obtenir des devis et trouver une entreprise', 'Fourniture Uniquement', 'lorem ipsum dolor sit amit', 'Occupé', '1000', '100', '1', NULL, '2017-12-23 19:03:34', '2017-12-24 23:54:36'),
(10, 1, 2, 37, 2, 'demande chanffage 2', 'Au plus vite', 'lorem ipsum dolor', 'Commerçant', 'Futur Propriétaire', 'Bureau', '5000', 'Demande de crédit en cours', 'Obtenir des devis et trouver une entreprise', 'Fourniture et Pose', 'lorem ipsum dolor', 'NRP', '1000', '100', '1', NULL, '2017-12-24 20:41:33', '2017-12-25 03:07:23'),
(11, 1, 4, 45, 2, 'installation de cuisine', 'Dans moins d\'un mois', 'lorem ipsum dolor sit amit lorem ipsum dolor sit amit lorem ipsum dolor sit amit lorem ipsum dolor sit amit lorem ipsum dolor sit amit lorem ipsum dolor sit amit lorem ipsum dolor sit amit lorem ipsum dolor sit amit.', '', '', 'Commerce', '5000', 'Crédit Obtenu', 'Obtenir des devis et trouver une entreprise', 'Pose Uniquement', 'lorem ipsum dolor sit amit lorem ipsum dolor sit amit lorem ipsum dolor sit amit lorem ipsum dolor sit amit lorem ipsum dolor sit amit lorem ipsum dolor sit amit lorem ipsum dolor sit amit lorem ipsum dolor sit amit.', 'Qualifié', '1000', '100', '1', NULL, '2017-12-24 23:19:08', '2017-12-25 03:01:23'),
(12, 1, 5, 46, 2, 'travaux salle de bain', 'Dans moins d\'un mois', 'lotem ipsum', 'Industriel', 'Futur Propriétaire', 'Commerce', '5000', 'Crédit Obtenu', 'Obtenir des devis et trouver une entreprise', 'Pose Uniquement', 'lorem ipsum dolor', 'Non qualifiée', '1000', '100', '1', NULL, '2017-12-25 01:28:11', '2017-12-25 02:54:56'),
(13, 1, 6, 47, 2, 'i want a sauna', 'Dans moins de 2 mois', 'lorem ipsum dolor sit amit lorem ipsum dolor sit amit lorem ipsum dolor sit amit lorem ipsum dolor sit amit lorem ipsum dolor sit amit', 'Profession Libérale', 'Locataire', 'Bureau', '5000', 'Crédit Obtenu', 'Obtenir des devis et trouver une entreprise', 'Pose Uniquement', 'lorem ipsum dolor sit amit lorem ipsum dolor sit amit lorem ipsum dolor sit amit lorem ipsum dolor sit amit lorem ipsum dolor sit amit', 'NRP', '1000', '300', '1', NULL, '2017-12-25 11:12:03', '2017-12-25 12:46:38'),
(14, 1, 7, 48, 2, 'je veux un spa', 'Dans moins de 2 mois', 'lorem ipsum dolor sit amit lorem ipsum dolor sit amit', 'Industriel', 'Locataire', 'Bureau', '4000', 'Demande de crédit en cours', 'Obtenir des devis et trouver une entreprise', 'Fourniture et Pose', 'lorem ipsum dolor sit amit lorem ipsum dolor sit amit lorem ipsum dolor sit amit lorem ipsum dolor sit amit', 'Qualifié', '1000', '100', '1', NULL, '2017-12-25 12:02:10', '2017-12-25 13:05:40');

-- --------------------------------------------------------

--
-- Table structure for table `geolocaliser`
--

DROP TABLE IF EXISTS `geolocaliser`;
CREATE TABLE `geolocaliser` (
  `ID_ARTISAN` bigint(20) NOT NULL,
  `ID_ZONE` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `particulier`
--

DROP TABLE IF EXISTS `particulier`;
CREATE TABLE `particulier` (
  `ID_PARTICULIER` bigint(20) NOT NULL,
  `NOM_PARTICULIER` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `PRENOM_PARTICULIER` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `TELEPHONE_FIXE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TELEPHONE_PORTABLE` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `CIVILITE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EMAIL` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `HORAIRERDV` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `particulier`
--

INSERT INTO `particulier` (`ID_PARTICULIER`, `NOM_PARTICULIER`, `PRENOM_PARTICULIER`, `TELEPHONE_FIXE`, `TELEPHONE_PORTABLE`, `CIVILITE`, `EMAIL`, `HORAIRERDV`) VALUES
(1, 'hutcherson', 'robert', '3176580687', '3176580687', 'M.', 'yerratbi@gmail.com', '10h-12h'),
(2, 'hutcherson', 'robert', '3176580687', '3176580687', 'M.', 'yerratbi@gmail.com', '10h-12h');

-- --------------------------------------------------------

--
-- Table structure for table `qualif_alarme_incendie`
--

DROP TABLE IF EXISTS `qualif_alarme_incendie`;
CREATE TABLE `qualif_alarme_incendie` (
  `ID_QUALIF_INCENDIE` bigint(20) NOT NULL,
  `ID_DEMANDE` bigint(20) NOT NULL,
  `SURFACE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NBRE_PIECE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TYPE_TRAVAUX` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `qualif_alarme_maison`
--

DROP TABLE IF EXISTS `qualif_alarme_maison`;
CREATE TABLE `qualif_alarme_maison` (
  `ID_QUALIF_MAISON` bigint(20) NOT NULL,
  `ID_DEMANDE` bigint(20) NOT NULL,
  `TYPE_ALARME` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TYPE_SYSTEME_ALARME` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NBRE_PIECE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NBRE_FENETRE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TYPE_TRAVAUX` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `qualif_chauffage`
--

DROP TABLE IF EXISTS `qualif_chauffage`;
CREATE TABLE `qualif_chauffage` (
  `ID_QUALIF_CHAUFFAGE` bigint(20) NOT NULL,
  `ID_DEMANDE` bigint(20) NOT NULL,
  `TYPE_CHAUFFAGE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TYPE_INSTALLATION` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CONDUITE_FUMEE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NBRE_ETAGE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SURFACE_TOTALE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `HAUTEUR_SOUS_PLAFOND` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TYPE_RADIATEUR` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TYPE_DIFFUSION_CHALEUR` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TYPE_ENERGIE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DISPOSE_JARDIN` tinyint(1) DEFAULT '0',
  `TYPE_TRAVAUX` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `qualif_chauffage`
--

INSERT INTO `qualif_chauffage` (`ID_QUALIF_CHAUFFAGE`, `ID_DEMANDE`, `TYPE_CHAUFFAGE`, `TYPE_INSTALLATION`, `CONDUITE_FUMEE`, `NBRE_ETAGE`, `SURFACE_TOTALE`, `HAUTEUR_SOUS_PLAFOND`, `TYPE_RADIATEUR`, `TYPE_DIFFUSION_CHALEUR`, `TYPE_ENERGIE`, `DISPOSE_JARDIN`, `TYPE_TRAVAUX`) VALUES
(1, 8, 'Chauffage à bois', 'Chauffage à Bois', 'A remplacer', '3', '100', '2.76', NULL, NULL, 'Géothermie/Aérothermie', NULL, 'Réparation'),
(10, 10, 'Chauffage electrique', NULL, NULL, 'plus de 3', '200', '2', 'Plancher chauffant électrique', NULL, NULL, NULL, 'Entretien/Maintenance');

-- --------------------------------------------------------

--
-- Table structure for table `qualif_climatisation`
--

DROP TABLE IF EXISTS `qualif_climatisation`;
CREATE TABLE `qualif_climatisation` (
  `ID_QUALIF_CLIMATISATION` bigint(20) NOT NULL,
  `ID_DEMANDE` bigint(20) NOT NULL,
  `NBRE_PIECE_A_CLIMATISER` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `SURFACE_CLIMATISER` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `HAUTEUR_PLAFOND` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `ACCORD_COPROPRIETE` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `TYPE_TRAVAUX` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `qualif_cuisine`
--

DROP TABLE IF EXISTS `qualif_cuisine`;
CREATE TABLE `qualif_cuisine` (
  `ID_QUALIF_CUISINE` bigint(20) NOT NULL,
  `ID_DEMANDE` bigint(20) NOT NULL,
  `DEPOSE_ANCIENNE_CUISINE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NIVEAU_GAMME_SOUHAITE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `STYLE_FUTUR_CUISINE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SURFACE_AU_SOL_CUISINE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TRAVAUX_PEINTURE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TRAVAUX_PLOMBERIE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TRAVAUX_REVETEMENT_SOL` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TRAVAUX_ELECTRICITE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EQUIPEMENT_ELECTROMENAGER` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `HAUTEUR_SOUS_PLAFOND` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TYPE_TRAVAUX` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `qualif_cuisine`
--

INSERT INTO `qualif_cuisine` (`ID_QUALIF_CUISINE`, `ID_DEMANDE`, `DEPOSE_ANCIENNE_CUISINE`, `NIVEAU_GAMME_SOUHAITE`, `STYLE_FUTUR_CUISINE`, `SURFACE_AU_SOL_CUISINE`, `TRAVAUX_PEINTURE`, `TRAVAUX_PLOMBERIE`, `TRAVAUX_REVETEMENT_SOL`, `TRAVAUX_ELECTRICITE`, `EQUIPEMENT_ELECTROMENAGER`, `HAUTEUR_SOUS_PLAFOND`, `TYPE_TRAVAUX`) VALUES
(2, 11, 'Oui', 'Premier Prix', 'Classique', 'Plus de 7 m²', 'Oui', 'Oui', 'Non', 'Oui', 'Oui', '2', 'Remplacer une Cuisine Existante');

-- --------------------------------------------------------

--
-- Table structure for table `qualif_demenagement`
--

DROP TABLE IF EXISTS `qualif_demenagement`;
CREATE TABLE `qualif_demenagement` (
  `ID_QUALIF_DEMENAGEMENT` bigint(20) NOT NULL,
  `ID_DEMANDE` bigint(20) NOT NULL,
  `TYPE_DEMENAGEMENT` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DEMENAGE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NBRE_PIECE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SURFACE_TOTALE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VILLE_DEPART` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PAYS_DEPART` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TYPE_LOGEMENT_DEPART` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NBRE_ETAGE_DEPART` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VILLE_ARRIVEE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PAYS_ARRIVEE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VOLUME_CONNUE` longblob,
  `VOLUME` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `qualif_fenetre`
--

DROP TABLE IF EXISTS `qualif_fenetre`;
CREATE TABLE `qualif_fenetre` (
  `ID_QUALIF_FENETRE` bigint(20) NOT NULL,
  `ID_DEMANDE` bigint(20) NOT NULL,
  `NBRE_FENETRE` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DEPOSE_FENETRE_EXISTANT` tinyint(1) DEFAULT '0',
  `TYPE_FENETRE` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `TYPE_TRAVAUX` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `qualif_fenetre`
--

INSERT INTO `qualif_fenetre` (`ID_QUALIF_FENETRE`, `ID_DEMANDE`, `NBRE_FENETRE`, `DEPOSE_FENETRE_EXISTANT`, `TYPE_FENETRE`, `TYPE_TRAVAUX`) VALUES
(2, 9, '4', 1, 'Bois', 'Réparation');

-- --------------------------------------------------------

--
-- Table structure for table `qualif_piscine`
--

DROP TABLE IF EXISTS `qualif_piscine`;
CREATE TABLE `qualif_piscine` (
  `ID_QUALIF_PISCINE` bigint(20) NOT NULL,
  `ID_DEMANDE` bigint(20) NOT NULL,
  `TYPE_PISCINE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DIMENSION` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `FORME_PISCINE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SECURITE_PISCINE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TYPE_TRAVAUX` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `qualif_porte_blindee`
--

DROP TABLE IF EXISTS `qualif_porte_blindee`;
CREATE TABLE `qualif_porte_blindee` (
  `ID_QUALIF_PORTE_BLINDEE` bigint(20) NOT NULL,
  `ID_DEMANDE` bigint(20) NOT NULL,
  `SURFACE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `GARDER_PORTE_ACTUELLE` longblob
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `qualif_salle_bain`
--

DROP TABLE IF EXISTS `qualif_salle_bain`;
CREATE TABLE `qualif_salle_bain` (
  `ID_QUALIF_SALLE_BAIN` bigint(20) NOT NULL,
  `ID_DEMANDE` bigint(20) DEFAULT NULL,
  `EQUIPEMENT_FUTUR_SALLE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SURFACE_AU_SOL` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DEPOSE_ANCIENNE_SALLE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TRAVAUX_PLOMBERIE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TRAVAUX_ELECTRICITE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TRAVAUX_REVETEMENT` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TRAVAUX_PEINTURE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `MEUBLE_RENGEMENT` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NIVEAU_GAMME` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `HAUTEUR_SOUS_PLAFOND` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TYPE_TRAVAUX` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `qualif_salle_bain`
--

INSERT INTO `qualif_salle_bain` (`ID_QUALIF_SALLE_BAIN`, `ID_DEMANDE`, `EQUIPEMENT_FUTUR_SALLE`, `SURFACE_AU_SOL`, `DEPOSE_ANCIENNE_SALLE`, `TRAVAUX_PLOMBERIE`, `TRAVAUX_ELECTRICITE`, `TRAVAUX_REVETEMENT`, `TRAVAUX_PEINTURE`, `MEUBLE_RENGEMENT`, `NIVEAU_GAMME`, `HAUTEUR_SOUS_PLAFOND`, `TYPE_TRAVAUX`) VALUES
(1, 12, 'Douche', 'Plus de 5 m²', 'Oui', 'Oui', NULL, 'Oui', 'Oui', NULL, 'Premier Prix', '3', 'Rénover une salle de bains existante');

-- --------------------------------------------------------

--
-- Table structure for table `qualif_sauna_hammam`
--

DROP TABLE IF EXISTS `qualif_sauna_hammam`;
CREATE TABLE `qualif_sauna_hammam` (
  `ID_QUALIF_SAUNA_HAMMAM` bigint(20) NOT NULL,
  `ID_DEMANDE` bigint(20) NOT NULL,
  `SURFACE_AU_SOL` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TRAVAUX_PLOMBERIE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TRAVAUX_ELECTRICITE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TRAVAUX_REVETEMENT` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TRAVAUX_PEINTURE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NIVEAU_GAMME` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TYPE_TRAVAUX` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `qualif_sauna_hammam`
--

INSERT INTO `qualif_sauna_hammam` (`ID_QUALIF_SAUNA_HAMMAM`, `ID_DEMANDE`, `SURFACE_AU_SOL`, `TRAVAUX_PLOMBERIE`, `TRAVAUX_ELECTRICITE`, `TRAVAUX_REVETEMENT`, `TRAVAUX_PEINTURE`, `NIVEAU_GAMME`, `TYPE_TRAVAUX`) VALUES
(1, 13, 'Plus de 5 m²', 'Oui', 'Oui', 'Oui', 'Non', 'Premier Prix', 'Créer un Sauna');

-- --------------------------------------------------------

--
-- Table structure for table `qualif_spa`
--

DROP TABLE IF EXISTS `qualif_spa`;
CREATE TABLE `qualif_spa` (
  `ID_QUALIF_SPA` bigint(20) NOT NULL,
  `ID_DEMANDE` bigint(20) NOT NULL,
  `SURFACE_AU_SOL` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TRAVAUX_PLOMBERIE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TRAVAUX_ELECTRICITE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TRAVAUX_REVETEMENT` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TRAVAUX_PEINTURE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NIVEAU_GAMME` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TYPE_TRAVAUX` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `qualif_spa`
--

INSERT INTO `qualif_spa` (`ID_QUALIF_SPA`, `ID_DEMANDE`, `SURFACE_AU_SOL`, `TRAVAUX_PLOMBERIE`, `TRAVAUX_ELECTRICITE`, `TRAVAUX_REVETEMENT`, `TRAVAUX_PEINTURE`, `NIVEAU_GAMME`, `TYPE_TRAVAUX`) VALUES
(1, 14, 'Plus de 7 m²', 'Oui', 'Oui', 'Non', 'Oui', 'Premier Prix', 'Créer un SPA');

-- --------------------------------------------------------

--
-- Table structure for table `qualif_video_surveillance`
--

DROP TABLE IF EXISTS `qualif_video_surveillance`;
CREATE TABLE `qualif_video_surveillance` (
  `ID_QUALIF_VIDEO` bigint(20) NOT NULL,
  `ID_DEMANDE` bigint(20) NOT NULL,
  `NBRE_PIECE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NBRE_FENETRE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `specialiste`
--

DROP TABLE IF EXISTS `specialiste`;
CREATE TABLE `specialiste` (
  `ID_ARTISAN` bigint(20) NOT NULL,
  `ID_ACTIVITE` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `ID_USER` bigint(20) NOT NULL,
  `FIRSTNAME_USER` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `LASTNAME_USER` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EMAIL_USER` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `LOGIN_USER` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PASSWORD_USER` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `RANK_USER` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ISACTIVE_USER` tinyint(1) NOT NULL DEFAULT '0',
  `DATEREGISTER_USER` date DEFAULT NULL,
  `LASTLOGIN_USER` date DEFAULT NULL,
  `TOKEN` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID_USER`, `FIRSTNAME_USER`, `LASTNAME_USER`, `EMAIL_USER`, `LOGIN_USER`, `PASSWORD_USER`, `RANK_USER`, `ISACTIVE_USER`, `DATEREGISTER_USER`, `LASTLOGIN_USER`, `TOKEN`) VALUES
(1, 'Abdelaziz', 'id mansour', 'aziz.idmansour@gmail.com', 'maidmansour', '49fb2fd3630355bc22647168c3df096ee1491f103983b028a2c252a712859bb2', '1', 49, '2017-12-20', NULL, NULL),
(2, 'youssef', 'Erratbi', 'yerratbi@gmail.com', 'erratbi', '6286d3c2600686e1b101d2a99a2a303fa145a6dd915855cfa6f18df3fedd8db7', NULL, 1, '2017-12-20', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `zone`
--

DROP TABLE IF EXISTS `zone`;
CREATE TABLE `zone` (
  `ID_ZONE` bigint(20) NOT NULL,
  `LIBELLE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `zone`
--

INSERT INTO `zone` (`ID_ZONE`, `LIBELLE`) VALUES
(1, '1'),
(2, '2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activite`
--
ALTER TABLE `activite`
  ADD PRIMARY KEY (`ID_ACTIVITE`);

--
-- Indexes for table `artisan`
--
ALTER TABLE `artisan`
  ADD PRIMARY KEY (`ID_ARTISAN`);

--
-- Indexes for table `chantier`
--
ALTER TABLE `chantier`
  ADD PRIMARY KEY (`ID_CHANTIER`),
  ADD KEY `FK_APPARTIENT` (`ID_ZONE`);

--
-- Indexes for table `demande_devis`
--
ALTER TABLE `demande_devis`
  ADD PRIMARY KEY (`ID_DEMANDE`),
  ADD KEY `FK_CATEGORISEE` (`ID_ACTIVITE`),
  ADD KEY `FK_CONCERNE` (`ID_CHANTIER`),
  ADD KEY `FK_FAIT` (`ID_PARTICULIER`),
  ADD KEY `FK_TRAITER` (`ID_USER`);

--
-- Indexes for table `geolocaliser`
--
ALTER TABLE `geolocaliser`
  ADD PRIMARY KEY (`ID_ARTISAN`,`ID_ZONE`),
  ADD KEY `FK_GEOLOCALISER` (`ID_ZONE`);

--
-- Indexes for table `particulier`
--
ALTER TABLE `particulier`
  ADD PRIMARY KEY (`ID_PARTICULIER`);

--
-- Indexes for table `qualif_alarme_incendie`
--
ALTER TABLE `qualif_alarme_incendie`
  ADD PRIMARY KEY (`ID_QUALIF_INCENDIE`),
  ADD KEY `FK_QUALIFIER_INCENDIE` (`ID_DEMANDE`);

--
-- Indexes for table `qualif_alarme_maison`
--
ALTER TABLE `qualif_alarme_maison`
  ADD PRIMARY KEY (`ID_QUALIF_MAISON`),
  ADD KEY `FK_QUALIFIER_AL_MAISON` (`ID_DEMANDE`);

--
-- Indexes for table `qualif_chauffage`
--
ALTER TABLE `qualif_chauffage`
  ADD PRIMARY KEY (`ID_QUALIF_CHAUFFAGE`),
  ADD KEY `FK_QUALIFIER_CHAUFFAGE` (`ID_DEMANDE`);

--
-- Indexes for table `qualif_climatisation`
--
ALTER TABLE `qualif_climatisation`
  ADD PRIMARY KEY (`ID_QUALIF_CLIMATISATION`),
  ADD KEY `FK_QUALIFIER_CLIMATISATION` (`ID_DEMANDE`);

--
-- Indexes for table `qualif_cuisine`
--
ALTER TABLE `qualif_cuisine`
  ADD PRIMARY KEY (`ID_QUALIF_CUISINE`),
  ADD KEY `FK_QUALIFIER_CUISINE` (`ID_DEMANDE`);

--
-- Indexes for table `qualif_demenagement`
--
ALTER TABLE `qualif_demenagement`
  ADD PRIMARY KEY (`ID_QUALIF_DEMENAGEMENT`),
  ADD KEY `FK_QUALIFIER_DEMENAGEMENT` (`ID_DEMANDE`);

--
-- Indexes for table `qualif_fenetre`
--
ALTER TABLE `qualif_fenetre`
  ADD PRIMARY KEY (`ID_QUALIF_FENETRE`),
  ADD KEY `FK_QUALIFIER_FENETRE` (`ID_DEMANDE`);

--
-- Indexes for table `qualif_piscine`
--
ALTER TABLE `qualif_piscine`
  ADD PRIMARY KEY (`ID_QUALIF_PISCINE`),
  ADD KEY `FK_QUALIFIER_PISCINE` (`ID_DEMANDE`);

--
-- Indexes for table `qualif_porte_blindee`
--
ALTER TABLE `qualif_porte_blindee`
  ADD PRIMARY KEY (`ID_QUALIF_PORTE_BLINDEE`),
  ADD KEY `FK_QUALIFIER_PORTE_BLINDEE` (`ID_DEMANDE`);

--
-- Indexes for table `qualif_salle_bain`
--
ALTER TABLE `qualif_salle_bain`
  ADD PRIMARY KEY (`ID_QUALIF_SALLE_BAIN`),
  ADD KEY `FK_QUALIFIER_SALLE_BAIN` (`ID_DEMANDE`);

--
-- Indexes for table `qualif_sauna_hammam`
--
ALTER TABLE `qualif_sauna_hammam`
  ADD PRIMARY KEY (`ID_QUALIF_SAUNA_HAMMAM`),
  ADD KEY `FK_QUALIFIER_SAUNA_SPA` (`ID_DEMANDE`);

--
-- Indexes for table `qualif_spa`
--
ALTER TABLE `qualif_spa`
  ADD PRIMARY KEY (`ID_QUALIF_SPA`),
  ADD KEY `FK_QUALIFIER_SAUNA_SPA` (`ID_DEMANDE`);

--
-- Indexes for table `qualif_video_surveillance`
--
ALTER TABLE `qualif_video_surveillance`
  ADD PRIMARY KEY (`ID_QUALIF_VIDEO`),
  ADD KEY `FK_QUALIFIER_VIDEO_SURVEILLANCE` (`ID_DEMANDE`);

--
-- Indexes for table `specialiste`
--
ALTER TABLE `specialiste`
  ADD PRIMARY KEY (`ID_ARTISAN`,`ID_ACTIVITE`),
  ADD KEY `FK_SPECIALISTE` (`ID_ACTIVITE`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID_USER`);

--
-- Indexes for table `zone`
--
ALTER TABLE `zone`
  ADD PRIMARY KEY (`ID_ZONE`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activite`
--
ALTER TABLE `activite`
  MODIFY `ID_ACTIVITE` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `artisan`
--
ALTER TABLE `artisan`
  MODIFY `ID_ARTISAN` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chantier`
--
ALTER TABLE `chantier`
  MODIFY `ID_CHANTIER` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `demande_devis`
--
ALTER TABLE `demande_devis`
  MODIFY `ID_DEMANDE` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `geolocaliser`
--
ALTER TABLE `geolocaliser`
  MODIFY `ID_ARTISAN` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `particulier`
--
ALTER TABLE `particulier`
  MODIFY `ID_PARTICULIER` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `qualif_alarme_incendie`
--
ALTER TABLE `qualif_alarme_incendie`
  MODIFY `ID_QUALIF_INCENDIE` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `qualif_alarme_maison`
--
ALTER TABLE `qualif_alarme_maison`
  MODIFY `ID_QUALIF_MAISON` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `qualif_chauffage`
--
ALTER TABLE `qualif_chauffage`
  MODIFY `ID_QUALIF_CHAUFFAGE` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `qualif_climatisation`
--
ALTER TABLE `qualif_climatisation`
  MODIFY `ID_QUALIF_CLIMATISATION` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `qualif_cuisine`
--
ALTER TABLE `qualif_cuisine`
  MODIFY `ID_QUALIF_CUISINE` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `qualif_demenagement`
--
ALTER TABLE `qualif_demenagement`
  MODIFY `ID_QUALIF_DEMENAGEMENT` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `qualif_fenetre`
--
ALTER TABLE `qualif_fenetre`
  MODIFY `ID_QUALIF_FENETRE` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `qualif_piscine`
--
ALTER TABLE `qualif_piscine`
  MODIFY `ID_QUALIF_PISCINE` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `qualif_porte_blindee`
--
ALTER TABLE `qualif_porte_blindee`
  MODIFY `ID_QUALIF_PORTE_BLINDEE` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `qualif_salle_bain`
--
ALTER TABLE `qualif_salle_bain`
  MODIFY `ID_QUALIF_SALLE_BAIN` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `qualif_sauna_hammam`
--
ALTER TABLE `qualif_sauna_hammam`
  MODIFY `ID_QUALIF_SAUNA_HAMMAM` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `qualif_spa`
--
ALTER TABLE `qualif_spa`
  MODIFY `ID_QUALIF_SPA` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `qualif_video_surveillance`
--
ALTER TABLE `qualif_video_surveillance`
  MODIFY `ID_QUALIF_VIDEO` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID_USER` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `zone`
--
ALTER TABLE `zone`
  MODIFY `ID_ZONE` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chantier`
--
ALTER TABLE `chantier`
  ADD CONSTRAINT `FK_APPARTIENT` FOREIGN KEY (`ID_ZONE`) REFERENCES `zone` (`id_zone`);

--
-- Constraints for table `demande_devis`
--
ALTER TABLE `demande_devis`
  ADD CONSTRAINT `FK_CATEGORISEE` FOREIGN KEY (`ID_ACTIVITE`) REFERENCES `activite` (`id_activite`),
  ADD CONSTRAINT `FK_CONCERNE` FOREIGN KEY (`ID_CHANTIER`) REFERENCES `chantier` (`id_chantier`),
  ADD CONSTRAINT `FK_FAIT` FOREIGN KEY (`ID_PARTICULIER`) REFERENCES `particulier` (`id_particulier`),
  ADD CONSTRAINT `FK_TRAITER` FOREIGN KEY (`ID_USER`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `geolocaliser`
--
ALTER TABLE `geolocaliser`
  ADD CONSTRAINT `FK_GEOLOCALISER` FOREIGN KEY (`ID_ZONE`) REFERENCES `zone` (`id_zone`),
  ADD CONSTRAINT `FK_GEOLOCALISER2` FOREIGN KEY (`ID_ARTISAN`) REFERENCES `artisan` (`id_artisan`);

--
-- Constraints for table `qualif_alarme_incendie`
--
ALTER TABLE `qualif_alarme_incendie`
  ADD CONSTRAINT `FK_QUALIFIER_INCENDIE` FOREIGN KEY (`ID_DEMANDE`) REFERENCES `demande_devis` (`id_demande`);

--
-- Constraints for table `qualif_alarme_maison`
--
ALTER TABLE `qualif_alarme_maison`
  ADD CONSTRAINT `FK_QUALIFIER_AL_MAISON` FOREIGN KEY (`ID_DEMANDE`) REFERENCES `demande_devis` (`id_demande`);

--
-- Constraints for table `qualif_chauffage`
--
ALTER TABLE `qualif_chauffage`
  ADD CONSTRAINT `FK_QUALIFIER_CHAUFFAGE` FOREIGN KEY (`ID_DEMANDE`) REFERENCES `demande_devis` (`id_demande`);

--
-- Constraints for table `qualif_climatisation`
--
ALTER TABLE `qualif_climatisation`
  ADD CONSTRAINT `FK_QUALIFIER_CLIMATISATION` FOREIGN KEY (`ID_DEMANDE`) REFERENCES `demande_devis` (`id_demande`);

--
-- Constraints for table `qualif_cuisine`
--
ALTER TABLE `qualif_cuisine`
  ADD CONSTRAINT `FK_QUALIFIER_CUISINE` FOREIGN KEY (`ID_DEMANDE`) REFERENCES `demande_devis` (`id_demande`);

--
-- Constraints for table `qualif_demenagement`
--
ALTER TABLE `qualif_demenagement`
  ADD CONSTRAINT `FK_QUALIFIER_DEMENAGEMENT` FOREIGN KEY (`ID_DEMANDE`) REFERENCES `demande_devis` (`id_demande`);

--
-- Constraints for table `qualif_fenetre`
--
ALTER TABLE `qualif_fenetre`
  ADD CONSTRAINT `FK_QUALIFIER_FENETRE` FOREIGN KEY (`ID_DEMANDE`) REFERENCES `demande_devis` (`id_demande`);

--
-- Constraints for table `qualif_piscine`
--
ALTER TABLE `qualif_piscine`
  ADD CONSTRAINT `FK_QUALIFIER_PISCINE` FOREIGN KEY (`ID_DEMANDE`) REFERENCES `demande_devis` (`id_demande`);

--
-- Constraints for table `qualif_porte_blindee`
--
ALTER TABLE `qualif_porte_blindee`
  ADD CONSTRAINT `FK_QUALIFIER_PORTE_BLINDEE` FOREIGN KEY (`ID_DEMANDE`) REFERENCES `demande_devis` (`id_demande`);

--
-- Constraints for table `qualif_salle_bain`
--
ALTER TABLE `qualif_salle_bain`
  ADD CONSTRAINT `FK_QUALIFIER_SALLE_BAIN` FOREIGN KEY (`ID_DEMANDE`) REFERENCES `demande_devis` (`id_demande`);

--
-- Constraints for table `qualif_sauna_hammam`
--
ALTER TABLE `qualif_sauna_hammam`
  ADD CONSTRAINT `FK_QUALIFIER_SAUNA_SPA` FOREIGN KEY (`ID_DEMANDE`) REFERENCES `demande_devis` (`id_demande`);

--
-- Constraints for table `qualif_video_surveillance`
--
ALTER TABLE `qualif_video_surveillance`
  ADD CONSTRAINT `FK_QUALIFIER_VIDEO_SURVEILLANCE` FOREIGN KEY (`ID_DEMANDE`) REFERENCES `demande_devis` (`id_demande`);

--
-- Constraints for table `specialiste`
--
ALTER TABLE `specialiste`
  ADD CONSTRAINT `FK_SPECIALISTE` FOREIGN KEY (`ID_ACTIVITE`) REFERENCES `activite` (`id_activite`),
  ADD CONSTRAINT `FK_SPECIALISTE2` FOREIGN KEY (`ID_ARTISAN`) REFERENCES `artisan` (`id_artisan`);
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
