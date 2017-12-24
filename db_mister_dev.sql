SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


DROP TABLE IF EXISTS `activite`;
CREATE TABLE `activite` (
  `ID_ACTIVITE` bigint(20) NOT NULL,
  `LIBELLE` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `activite` (`ID_ACTIVITE`, `LIBELLE`) VALUES
(1, 'PISCINE'),
(2, 'CHAUFFAGE'),
(3, 'FENETRE');

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

DROP TABLE IF EXISTS `chantier`;
CREATE TABLE `chantier` (
  `ID_CHANTIER` bigint(20) NOT NULL,
  `ID_ZONE` bigint(20) NOT NULL,
  `ADRESSE` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `ADRESSE2` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VILLE` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `CODE_POSTAL` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `chantier` (`ID_CHANTIER`, `ID_ZONE`, `ADRESSE`, `ADRESSE2`, `VILLE`, `CODE_POSTAL`) VALUES
(22, 1, 'QUARTIER DECHAMPS N°253', 'SYBA', 'PARIS', '75004'),
(23, 1, 'Winterfell', 'The north', 'Westros', '66000'),
(24, 2, '433 STEWART STREET', '', 'INDIANAPOLIS', '47715'),
(25, 2, '433 STEWART STREET', '', 'INDIANAPOLIS', '47715'),
(26, 2, '2nd street', 'Derry', 'Maine', '5909'),
(27, 1, 'Bushwick Brooklyn, NY', '', 'Brooklyn', '11207'),
(28, 2, '22 1B Baker street', '', 'London', '2049'),
(29, 2, 'Dragonstone', '', 'Westros', '2988');

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

INSERT INTO `demande_devis` (`ID_DEMANDE`, `ID_PARTICULIER`, `ID_ACTIVITE`, `ID_CHANTIER`, `ID_USER`, `TITRE_DEMANDE`, `DELAI_SOUHAITE`, `DESCRIPTION`, `TYPE_DEMANDEUR`, `TYPE_PROPRIETE`, `TYPE_BATIMENT`, `BUDGET_APPROXIMATIF`, `FINANCEMENT_PROJET`, `OBJECTIF_DEMANDE`, `PRESTATION_SOUHAITE`, `INDICATION_COMPLEMENTAIRE`, `QUALIFICATION`, `PRIX_MISE_EN_LIGNE`, `PRIX_PROMO`, `PUBLIER_EN_LIGNE`, `CHEMIN_PDF`, `DATE_CREATION`, `DATE_PUBLICATION`) VALUES
(8, 2, 2, 28, 2, 'Installation chauffage', 'Dans moins d\'un mois', 'Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet .', 'Autre', 'Administrateur', 'Immeuble', '1000', 'Crédit Obtenu', 'Obtenir des devis et trouver une entreprise', 'Pose Uniquement', 'Lorem ipsum dolor sit amet  Lorem ipsum dolor sit amet  Lorem ipsum dolor sit amet  Lorem ipsum dolor sit amet  Lorem ipsum dolor sit amet  Lorem ipsum dolor sit amet  Lorem ipsum dolor sit amet  Lorem ipsum dolor sit amet  Lorem ipsum dolor sit amet  Lorem ipsum dolor sit amet  Lorem ipsum dolor sit amet .', '4', '1000', '3000', '1', NULL, '2017-12-23 18:44:19', '2017-12-23 20:02:35'),
(9, 1, 3, 29, 2, 'Reparation de fenêtres', 'Plus de six mois', 'Lorem ipsum dolor sit amit Lorem ipsum dolor sit amit Lorem ipsum dolor sit amit Lorem ipsum dolor sit amit Lorem ipsum dolor sit amit Lorem ipsum dolor sit amit Lorem ipsum dolor sit amit Lorem ipsum dolor sit amit Lorem ipsum dolor sit amit Lorem ipsum dolor sit amit Lorem ipsum dolor sit amit Lorem ipsum dolor sit amit ', 'Profession Libérale', 'Locataire', 'Local Industriel', '2000', 'Crédit Obtenu', 'Autre', 'Pose Uniquement', 'Lorem ipsum dolor sit amit Lorem ipsum dolor sit amit Lorem ipsum dolor sit amit Lorem ipsum dolor sit amit Lorem ipsum dolor sit amit Lorem ipsum dolor sit amit Lorem ipsum dolor sit amit ', '2', '898', '300', '1', NULL, '2017-12-23 19:03:34', '2017-12-23 20:10:08');

DROP TABLE IF EXISTS `geolocaliser`;
CREATE TABLE `geolocaliser` (
  `ID_ARTISAN` bigint(20) NOT NULL,
  `ID_ZONE` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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

INSERT INTO `particulier` (`ID_PARTICULIER`, `NOM_PARTICULIER`, `PRENOM_PARTICULIER`, `TELEPHONE_FIXE`, `TELEPHONE_PORTABLE`, `CIVILITE`, `EMAIL`, `HORAIRERDV`) VALUES
(1, 'Lannister', 'Tyrion', '3176580687', '2162883905', 'Monsieur', 'y.err.atbi@gmail.com', '10h-12h'),
(2, 'HUTCHERSON', 'ROBERT', '3176580687', '3176580687', 'Monsieur', 'yerratbi@gmail.com', '10h-12h');

DROP TABLE IF EXISTS `qualif_alarme_incendie`;
CREATE TABLE `qualif_alarme_incendie` (
  `ID_QUALIF_INCENDIE` bigint(20) NOT NULL,
  `ID_DEMANDE` bigint(20) NOT NULL,
  `SURFACE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NBRE_PIECE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TYPE_TRAVAUX` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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

INSERT INTO `qualif_chauffage` (`ID_QUALIF_CHAUFFAGE`, `ID_DEMANDE`, `TYPE_CHAUFFAGE`, `TYPE_INSTALLATION`, `CONDUITE_FUMEE`, `NBRE_ETAGE`, `SURFACE_TOTALE`, `HAUTEUR_SOUS_PLAFOND`, `TYPE_RADIATEUR`, `TYPE_DIFFUSION_CHALEUR`, `TYPE_ENERGIE`, `DISPOSE_JARDIN`, `TYPE_TRAVAUX`) VALUES
(1, 8, 'Chauffage eau thermodynamique', NULL, NULL, '3', '100', '2.76', NULL, NULL, 'Géothermie/Aérothermie', NULL, 'Réparation');

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

DROP TABLE IF EXISTS `qualif_cuisine`;
CREATE TABLE `qualif_cuisine` (
  `ID_QUALIF_CUISINE` bigint(20) NOT NULL,
  `ID_DEMANDE` bigint(20) NOT NULL,
  `DEPOSE_ANCIENNE_CUISINE` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `HAUTEUR_SOUS_PLAFOND` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `NIVEAU_GAMME_SOUHAITE` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `STYLE_FUTUR_CUISINE` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `SURFACE_AU_SOL_CUISINE` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `TRAVAUX_PEINTURE` longblob NOT NULL,
  `TRAVAUX_PLOMBERIE` longblob NOT NULL,
  `TRAVAUX_REVETEMENT_SOL` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `TRAVAUX_ELECTRICITE` longblob NOT NULL,
  `EQUIPEMENT_ELECTROMENAGER` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `TYPE_TRAVAUX` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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

DROP TABLE IF EXISTS `qualif_fenetre`;
CREATE TABLE `qualif_fenetre` (
  `ID_QUALIF_FENETRE` bigint(20) NOT NULL,
  `ID_DEMANDE` bigint(20) NOT NULL,
  `NBRE_FENETRE` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DEPOSE_FENETRE_EXISTANT` tinyint(1) DEFAULT '0',
  `TYPE_FENETRE` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `TYPE_TRAVAUX` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `qualif_fenetre` (`ID_QUALIF_FENETRE`, `ID_DEMANDE`, `NBRE_FENETRE`, `DEPOSE_FENETRE_EXISTANT`, `TYPE_FENETRE`, `TYPE_TRAVAUX`) VALUES
(1, 9, '4', 0, 'Fenêtre de toit', 'Réparation');

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

DROP TABLE IF EXISTS `qualif_porte_blindee`;
CREATE TABLE `qualif_porte_blindee` (
  `ID_QUALIF_PORTE_BLINDEE` bigint(20) NOT NULL,
  `ID_DEMANDE` bigint(20) NOT NULL,
  `SURFACE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `GARDER_PORTE_ACTUELLE` longblob
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `qualif_salle_bain`;
CREATE TABLE `qualif_salle_bain` (
  `ID_QUALIF_SALLE_BAIN` bigint(20) NOT NULL,
  `ID_DEMANDE` bigint(20) NOT NULL,
  `EQUIPEMENT_FUTUR_SALLE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SURFACE_AU_SOL` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DEPOSE_ANCIENNE_SALLE` longblob,
  `TRAVAUX_PLOMBERIE` longblob,
  `TRAVAUX_ELECTRECITE` longblob,
  `TRAVAUX_REVETEMENT` longblob,
  `TRAVAUX_PEINTURE` longblob,
  `MEUBLE_RENGEMENT` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NIVEAU_GAMME` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `HAUTEUR_SOUS_PLAFOND` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TYPE_TRAVAUX` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `qualif_sauna_spa`;
CREATE TABLE `qualif_sauna_spa` (
  `ID_QUALIF_SAUNA_SPA` bigint(20) NOT NULL,
  `ID_DEMANDE` bigint(20) NOT NULL,
  `SURAFCE_AU_SOL` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TRAVAUX_PLOMBERIE` longblob,
  `TRAVAUX_ELECTRICITE` longblob,
  `TRAVAUX_REVETEMENT` longblob,
  `TRAVAUX_PEINTURE` longblob,
  `NIVEAU_GAMME` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TYPE_TRAVAUX` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `qualif_video_surveillance`;
CREATE TABLE `qualif_video_surveillance` (
  `ID_QUALIF_VIDEO` bigint(20) NOT NULL,
  `ID_DEMANDE` bigint(20) NOT NULL,
  `NBRE_PIECE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NBRE_FENETRE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `specialiste`;
CREATE TABLE `specialiste` (
  `ID_ARTISAN` bigint(20) NOT NULL,
  `ID_ACTIVITE` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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

INSERT INTO `user` (`ID_USER`, `FIRSTNAME_USER`, `LASTNAME_USER`, `EMAIL_USER`, `LOGIN_USER`, `PASSWORD_USER`, `RANK_USER`, `ISACTIVE_USER`, `DATEREGISTER_USER`, `LASTLOGIN_USER`, `TOKEN`) VALUES
(1, 'Abdelaziz', 'id mansour', 'aziz.idmansour@gmail.com', 'maidmansour', '49fb2fd3630355bc22647168c3df096ee1491f103983b028a2c252a712859bb2', '1', 49, '2017-12-20', NULL, NULL),
(2, 'youssef', 'Erratbi', 'yerratbi@gmail.com', 'erratbi', '6286d3c2600686e1b101d2a99a2a303fa145a6dd915855cfa6f18df3fedd8db7', NULL, 1, '2017-12-20', NULL, NULL);

DROP TABLE IF EXISTS `zone`;
CREATE TABLE `zone` (
  `ID_ZONE` bigint(20) NOT NULL,
  `LIBELLE` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `zone` (`ID_ZONE`, `LIBELLE`) VALUES
(1, '1'),
(2, '2');


ALTER TABLE `activite`
  ADD PRIMARY KEY (`ID_ACTIVITE`);

ALTER TABLE `artisan`
  ADD PRIMARY KEY (`ID_ARTISAN`);

ALTER TABLE `chantier`
  ADD PRIMARY KEY (`ID_CHANTIER`),
  ADD KEY `FK_APPARTIENT` (`ID_ZONE`);

ALTER TABLE `demande_devis`
  ADD PRIMARY KEY (`ID_DEMANDE`),
  ADD KEY `FK_CATEGORISEE` (`ID_ACTIVITE`),
  ADD KEY `FK_CONCERNE` (`ID_CHANTIER`),
  ADD KEY `FK_FAIT` (`ID_PARTICULIER`),
  ADD KEY `FK_TRAITER` (`ID_USER`);

ALTER TABLE `geolocaliser`
  ADD PRIMARY KEY (`ID_ARTISAN`,`ID_ZONE`),
  ADD KEY `FK_GEOLOCALISER` (`ID_ZONE`);

ALTER TABLE `particulier`
  ADD PRIMARY KEY (`ID_PARTICULIER`);

ALTER TABLE `qualif_alarme_incendie`
  ADD PRIMARY KEY (`ID_QUALIF_INCENDIE`),
  ADD KEY `FK_QUALIFIER_INCENDIE` (`ID_DEMANDE`);

ALTER TABLE `qualif_alarme_maison`
  ADD PRIMARY KEY (`ID_QUALIF_MAISON`),
  ADD KEY `FK_QUALIFIER_AL_MAISON` (`ID_DEMANDE`);

ALTER TABLE `qualif_chauffage`
  ADD PRIMARY KEY (`ID_QUALIF_CHAUFFAGE`),
  ADD KEY `FK_QUALIFIER_CHAUFFAGE` (`ID_DEMANDE`);

ALTER TABLE `qualif_climatisation`
  ADD PRIMARY KEY (`ID_QUALIF_CLIMATISATION`),
  ADD KEY `FK_QUALIFIER_CLIMATISATION` (`ID_DEMANDE`);

ALTER TABLE `qualif_cuisine`
  ADD PRIMARY KEY (`ID_QUALIF_CUISINE`),
  ADD KEY `FK_QUALIFIER_CUISINE` (`ID_DEMANDE`);

ALTER TABLE `qualif_demenagement`
  ADD PRIMARY KEY (`ID_QUALIF_DEMENAGEMENT`),
  ADD KEY `FK_QUALIFIER_DEMENAGEMENT` (`ID_DEMANDE`);

ALTER TABLE `qualif_fenetre`
  ADD PRIMARY KEY (`ID_QUALIF_FENETRE`),
  ADD KEY `FK_QUALIFIER_FENETRE` (`ID_DEMANDE`);

ALTER TABLE `qualif_piscine`
  ADD PRIMARY KEY (`ID_QUALIF_PISCINE`),
  ADD KEY `FK_QUALIFIER_PISCINE` (`ID_DEMANDE`);

ALTER TABLE `qualif_porte_blindee`
  ADD PRIMARY KEY (`ID_QUALIF_PORTE_BLINDEE`),
  ADD KEY `FK_QUALIFIER_PORTE_BLINDEE` (`ID_DEMANDE`);

ALTER TABLE `qualif_salle_bain`
  ADD PRIMARY KEY (`ID_QUALIF_SALLE_BAIN`),
  ADD KEY `FK_QUALIFIER_SALLE_BAIN` (`ID_DEMANDE`);

ALTER TABLE `qualif_sauna_spa`
  ADD PRIMARY KEY (`ID_QUALIF_SAUNA_SPA`),
  ADD KEY `FK_QUALIFIER_SAUNA_SPA` (`ID_DEMANDE`);

ALTER TABLE `qualif_video_surveillance`
  ADD PRIMARY KEY (`ID_QUALIF_VIDEO`),
  ADD KEY `FK_QUALIFIER_VIDEO_SURVEILLANCE` (`ID_DEMANDE`);

ALTER TABLE `specialiste`
  ADD PRIMARY KEY (`ID_ARTISAN`,`ID_ACTIVITE`),
  ADD KEY `FK_SPECIALISTE` (`ID_ACTIVITE`);

ALTER TABLE `user`
  ADD PRIMARY KEY (`ID_USER`);

ALTER TABLE `zone`
  ADD PRIMARY KEY (`ID_ZONE`);


ALTER TABLE `activite`
  MODIFY `ID_ACTIVITE` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `artisan`
  MODIFY `ID_ARTISAN` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `chantier`
  MODIFY `ID_CHANTIER` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `demande_devis`
  MODIFY `ID_DEMANDE` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `geolocaliser`
  MODIFY `ID_ARTISAN` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `particulier`
  MODIFY `ID_PARTICULIER` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `qualif_alarme_incendie`
  MODIFY `ID_QUALIF_INCENDIE` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `qualif_alarme_maison`
  MODIFY `ID_QUALIF_MAISON` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `qualif_chauffage`
  MODIFY `ID_QUALIF_CHAUFFAGE` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `qualif_climatisation`
  MODIFY `ID_QUALIF_CLIMATISATION` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `qualif_cuisine`
  MODIFY `ID_QUALIF_CUISINE` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `qualif_demenagement`
  MODIFY `ID_QUALIF_DEMENAGEMENT` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `qualif_fenetre`
  MODIFY `ID_QUALIF_FENETRE` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `qualif_piscine`
  MODIFY `ID_QUALIF_PISCINE` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `qualif_porte_blindee`
  MODIFY `ID_QUALIF_PORTE_BLINDEE` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `qualif_salle_bain`
  MODIFY `ID_QUALIF_SALLE_BAIN` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `qualif_sauna_spa`
  MODIFY `ID_QUALIF_SAUNA_SPA` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `qualif_video_surveillance`
  MODIFY `ID_QUALIF_VIDEO` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user`
  MODIFY `ID_USER` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `zone`
  MODIFY `ID_ZONE` bigint(20) NOT NULL AUTO_INCREMENT;


ALTER TABLE `chantier`
  ADD CONSTRAINT `FK_APPARTIENT` FOREIGN KEY (`ID_ZONE`) REFERENCES `zone` (`id_zone`);

ALTER TABLE `demande_devis`
  ADD CONSTRAINT `FK_CATEGORISEE` FOREIGN KEY (`ID_ACTIVITE`) REFERENCES `activite` (`id_activite`),
  ADD CONSTRAINT `FK_CONCERNE` FOREIGN KEY (`ID_CHANTIER`) REFERENCES `chantier` (`id_chantier`),
  ADD CONSTRAINT `FK_FAIT` FOREIGN KEY (`ID_PARTICULIER`) REFERENCES `particulier` (`id_particulier`),
  ADD CONSTRAINT `FK_TRAITER` FOREIGN KEY (`ID_USER`) REFERENCES `user` (`id_user`);

ALTER TABLE `geolocaliser`
  ADD CONSTRAINT `FK_GEOLOCALISER` FOREIGN KEY (`ID_ZONE`) REFERENCES `zone` (`id_zone`),
  ADD CONSTRAINT `FK_GEOLOCALISER2` FOREIGN KEY (`ID_ARTISAN`) REFERENCES `artisan` (`id_artisan`);

ALTER TABLE `qualif_alarme_incendie`
  ADD CONSTRAINT `FK_QUALIFIER_INCENDIE` FOREIGN KEY (`ID_DEMANDE`) REFERENCES `demande_devis` (`id_demande`);

ALTER TABLE `qualif_alarme_maison`
  ADD CONSTRAINT `FK_QUALIFIER_AL_MAISON` FOREIGN KEY (`ID_DEMANDE`) REFERENCES `demande_devis` (`id_demande`);

ALTER TABLE `qualif_chauffage`
  ADD CONSTRAINT `FK_QUALIFIER_CHAUFFAGE` FOREIGN KEY (`ID_DEMANDE`) REFERENCES `demande_devis` (`id_demande`);

ALTER TABLE `qualif_climatisation`
  ADD CONSTRAINT `FK_QUALIFIER_CLIMATISATION` FOREIGN KEY (`ID_DEMANDE`) REFERENCES `demande_devis` (`id_demande`);

ALTER TABLE `qualif_cuisine`
  ADD CONSTRAINT `FK_QUALIFIER_CUISINE` FOREIGN KEY (`ID_DEMANDE`) REFERENCES `demande_devis` (`id_demande`);

ALTER TABLE `qualif_demenagement`
  ADD CONSTRAINT `FK_QUALIFIER_DEMENAGEMENT` FOREIGN KEY (`ID_DEMANDE`) REFERENCES `demande_devis` (`id_demande`);

ALTER TABLE `qualif_fenetre`
  ADD CONSTRAINT `FK_QUALIFIER_FENETRE` FOREIGN KEY (`ID_DEMANDE`) REFERENCES `demande_devis` (`id_demande`);

ALTER TABLE `qualif_piscine`
  ADD CONSTRAINT `FK_QUALIFIER_PISCINE` FOREIGN KEY (`ID_DEMANDE`) REFERENCES `demande_devis` (`id_demande`);

ALTER TABLE `qualif_porte_blindee`
  ADD CONSTRAINT `FK_QUALIFIER_PORTE_BLINDEE` FOREIGN KEY (`ID_DEMANDE`) REFERENCES `demande_devis` (`id_demande`);

ALTER TABLE `qualif_salle_bain`
  ADD CONSTRAINT `FK_QUALIFIER_SALLE_BAIN` FOREIGN KEY (`ID_DEMANDE`) REFERENCES `demande_devis` (`id_demande`);

ALTER TABLE `qualif_sauna_spa`
  ADD CONSTRAINT `FK_QUALIFIER_SAUNA_SPA` FOREIGN KEY (`ID_DEMANDE`) REFERENCES `demande_devis` (`id_demande`);

ALTER TABLE `qualif_video_surveillance`
  ADD CONSTRAINT `FK_QUALIFIER_VIDEO_SURVEILLANCE` FOREIGN KEY (`ID_DEMANDE`) REFERENCES `demande_devis` (`id_demande`);

ALTER TABLE `specialiste`
  ADD CONSTRAINT `FK_SPECIALISTE` FOREIGN KEY (`ID_ACTIVITE`) REFERENCES `activite` (`id_activite`),
  ADD CONSTRAINT `FK_SPECIALISTE2` FOREIGN KEY (`ID_ARTISAN`) REFERENCES `artisan` (`id_artisan`);
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
