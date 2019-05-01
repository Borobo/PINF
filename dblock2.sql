-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 01 avr. 2019 à 14:02
-- Version du serveur :  5.7.19
-- Version de PHP :  5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `dblock2`
--

-- --------------------------------------------------------

--
-- Structure de la table `bdd`
--

DROP TABLE IF EXISTS `bdd`;
CREATE TABLE IF NOT EXISTS `bdd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `idCreateur` int(11) DEFAULT NULL,
  `creee` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idCreateur` (`idCreateur`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `bdd`
--

INSERT INTO `bdd` (`id`, `nom`, `description`, `idCreateur`, `creee`) VALUES
(1, 'bdd1', NULL, 1, 1),
(2, 'bdd2', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `colonne`
--

DROP TABLE IF EXISTS `colonne`;
CREATE TABLE IF NOT EXISTS `colonne` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(40) DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL,
  `idTab` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idTab` (`idTab`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `colonne`
--

INSERT INTO `colonne` (`id`, `label`, `description`, `idTab`) VALUES
(1, 'prenom', NULL, 1),
(2, 'nom', NULL, 1),
(3, 'id', NULL, 2),
(4, 'marque', NULL, 2),
(5, 'date', NULL, 2),
(56, 'titre', '1', 75),
(55, 'a', '1', 69);

-- --------------------------------------------------------

--
-- Structure de la table `data`
--

DROP TABLE IF EXISTS `data`;
CREATE TABLE IF NOT EXISTS `data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `valInt` float DEFAULT NULL,
  `valChar` varchar(1000) DEFAULT NULL,
  `idColonne` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idColonne` (`idColonne`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `data`
--

INSERT INTO `data` (`id`, `valInt`, `valChar`, `idColonne`) VALUES
(1, NULL, 'sacha', 1),
(2, NULL, '', 2),
(3, 1, NULL, 3);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `lebon`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `lebon`;
CREATE TABLE IF NOT EXISTS `lebon` (
`idBdd` int(11)
,`nom` varchar(30)
,`prenom` varchar(30)
,`identifiant` varchar(30)
,`grade` varchar(5)
);

-- --------------------------------------------------------

--
-- Structure de la table `liste_user`
--

DROP TABLE IF EXISTS `liste_user`;
CREATE TABLE IF NOT EXISTS `liste_user` (
  `idBdd` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idBdd`,`idUser`),
  KEY `idBdd` (`idBdd`),
  KEY `idUser` (`idUser`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `liste_user`
--

INSERT INTO `liste_user` (`idBdd`, `idUser`, `admin`) VALUES
(2, 1, 1),
(1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `tab`
--

DROP TABLE IF EXISTS `tab`;
CREATE TABLE IF NOT EXISTS `tab` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(20) DEFAULT NULL,
  `idBdd` int(11) DEFAULT NULL,
  `idUser` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idBdd` (`idBdd`),
  KEY `idUser` (`idUser`)
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tab`
--

INSERT INTO `tab` (`id`, `label`, `idBdd`, `idUser`) VALUES
(1, 'user', 1, NULL),
(2, 'voitures', 1, NULL),
(3, 'test', 1, NULL),
(7, 'PAS BIEN', 2, NULL),
(75, 'missions', 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prenom` varchar(30) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `superadmin` tinyint(1) DEFAULT '0',
  `password` varchar(30) NOT NULL,
  `identifiant` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `prenom`, `nom`, `superadmin`, `password`, `identifiant`) VALUES
(1, 'aaa', 'aaa', 0, '123', 'aaa'),
(2, 'John', 'Doe', 1, 'admin', 'admin'),
(4, 'Clément', 'Bréhard', 1, 'clemi', 'clemi'),
(5, 'Sacha', 'Lesueur', 1, 'slesueur', 'slesueur'),
(6, 'Lucas', 'Tesson', 0, 'ltesson', 'ltesson');

-- --------------------------------------------------------

--
-- Structure de la vue `lebon`
--
DROP TABLE IF EXISTS `lebon`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `lebon`  AS  select `liste_user`.`idBdd` AS `idBdd`,`user`.`nom` AS `nom`,`user`.`prenom` AS `prenom`,`user`.`identifiant` AS `identifiant`,if((`liste_user`.`admin` = 1),'ADMIN','USER') AS `grade` from (`liste_user` join `user`) where (`liste_user`.`idUser` = `user`.`id`) ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
