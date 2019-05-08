-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 08 mai 2019 à 12:58
-- Version du serveur :  5.7.23
-- Version de PHP :  7.2.10

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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `bdd`
--

INSERT INTO `bdd` (`id`, `nom`, `description`, `idCreateur`, `creee`) VALUES
(1, 'bdd1', NULL, NULL, 1),
(2, 'bdd2', NULL, NULL, 1),
(3, 'bdd3', 'non créée', NULL, 0),
(4, 'test', 'yo', 1, 1),
(5, 'Magnolia', 'lol', 5, 1);

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
  `type` varchar(20) NOT NULL,
  `A_I` tinyint(1) NOT NULL DEFAULT '0',
  `UNIQ` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idTab` (`idTab`)
) ENGINE=MyISAM AUTO_INCREMENT=130 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `colonne`
--

INSERT INTO `colonne` (`id`, `label`, `description`, `idTab`, `type`, `A_I`, `UNIQ`) VALUES
(108, 'telephone', '', 103, 'Nombre', 0, 0),
(107, 'adresse', 'adresse de l\'utilisateur', 103, 'Texte', 0, 0),
(106, 'prenom', 'prenom de l\'utilisateur', 103, 'Texte', 0, 0),
(104, 'id', 'id de l\'utilisateur', 103, 'Nombre', 0, 0),
(105, 'nom', 'nom de l\'utilisateur', 103, 'Texte', 0, 0),
(119, 'test 1', '', 105, 'Texte', 0, 0),
(120, 'test 2', '', 105, 'Nombre', 1, 0),
(121, 'test 3', '', 105, 'Nombre', 1, 0),
(122, 'test 4', '', 105, 'Texte', 0, 1),
(123, 'test 5', '', 105, 'Texte', 0, 0),
(124, 'rererere', 'rerere', 109, 'Nombre', 1, 0),
(127, 'id', '', 111, 'Nombre', 1, 0),
(128, 'nom', '', 111, 'Texte', 0, 0),
(129, 'prenom', '', 111, 'Texte', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `data`
--

DROP TABLE IF EXISTS `data`;
CREATE TABLE IF NOT EXISTS `data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `valInt` decimal(10,0) DEFAULT NULL,
  `valChar` varchar(1000) DEFAULT NULL,
  `idColonne` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idColonne` (`idColonne`)
) ENGINE=MyISAM AUTO_INCREMENT=68 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `data`
--

INSERT INTO `data` (`id`, `valInt`, `valChar`, `idColonne`) VALUES
(18, NULL, 'Sacha', 106),
(19, NULL, '20b', 107),
(17, NULL, 'LESUEUR', 105),
(16, '1', NULL, 104),
(22, NULL, 'TESSOn', 105),
(21, '2', NULL, 104),
(20, '62333', NULL, 108),
(23, NULL, 'Lucas', 106),
(24, NULL, '20b ', 107),
(25, '48794', NULL, 108),
(26, '1', NULL, 127),
(27, NULL, 'LESUEUR', 128),
(28, NULL, 'Guillaume', 129),
(40, NULL, 'a', 129),
(39, NULL, 'a', 128),
(32, '3', NULL, 127),
(33, NULL, 'MENON', 128),
(34, NULL, 'Martin', 129),
(38, '4', NULL, 127),
(41, '5', NULL, 127),
(42, NULL, 'a', 128),
(43, NULL, 'a', 129),
(44, '6', NULL, 127),
(45, NULL, 'a', 128),
(46, NULL, 'a', 129),
(47, '7', NULL, 127),
(48, NULL, 'a', 128),
(49, NULL, 'a', 129),
(50, '8', NULL, 127),
(51, NULL, 'a', 128),
(52, NULL, 'a', 129),
(53, '9', NULL, 127),
(54, NULL, 'a', 128),
(55, NULL, 'a', 129),
(56, '10', NULL, 127),
(57, NULL, 'a', 128),
(58, NULL, 'a', 129),
(59, '11', NULL, 127),
(60, NULL, 'a', 128),
(61, NULL, 'a', 129),
(62, '12', NULL, 127),
(63, NULL, 'a', 128),
(64, NULL, 'a', 129),
(65, '13', NULL, 127),
(66, NULL, 'a', 128),
(67, NULL, 'a', 129);

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
(1, 1, 1),
(2, 1, 0),
(1, 2, 1),
(2, 2, 1),
(1, 6, 0),
(1, 4, 1),
(1, 5, 1),
(5, 5, 1),
(6, 6, 1);

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
) ENGINE=MyISAM AUTO_INCREMENT=112 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tab`
--

INSERT INTO `tab` (`id`, `label`, `idBdd`, `idUser`) VALUES
(90, 'lol', NULL, NULL),
(7, 'PAS BIEN', 2, NULL),
(89, 'lol', NULL, NULL),
(88, 'test', NULL, NULL),
(87, 'Users', NULL, NULL),
(111, 'TEST', 1, 5),
(109, 'Paulux', 1, 5),
(91, 'table', NULL, NULL),
(92, 'test1', NULL, NULL),
(93, 'l', NULL, NULL),
(94, '1', NULL, NULL),
(95, 'lo', NULL, NULL),
(96, 'test123', NULL, NULL),
(105, 'test', 1, 5),
(103, 'Utilisateur', 1, 5);

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
