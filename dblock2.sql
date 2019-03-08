-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 08 mars 2019 à 13:02
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
  PRIMARY KEY (`id`),
  KEY `idCreateur` (`idCreateur`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `bdd`
--

INSERT INTO `bdd` (`id`, `nom`, `description`, `idCreateur`) VALUES
(1, 'BDD3', 'Ceci est la description de la BDD3', 1),
(4, 'test2', 'testest2', 1),
(5, 'test3', 'testtest3', 1),
(2, 'yoooo', 'oui bonjour', 1),
(12, 'ouaiiii', 'Décris moi ça', 2),
(13, 'bdd8', 'c\'est bien comme description pour la bdd8', 1);

-- --------------------------------------------------------

--
-- Structure de la table `colonne`
--

DROP TABLE IF EXISTS `colonne`;
CREATE TABLE IF NOT EXISTS `colonne` (
  `id` int(11) NOT NULL,
  `label` varchar(40) DEFAULT NULL,
  `idTab` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idTab` (`idTab`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `colonne`
--

INSERT INTO `colonne` (`id`, `label`, `idTab`) VALUES
(1, 'prenom', 1),
(2, 'nom', 1),
(3, 'id', 2),
(4, 'marque', 2),
(5, 'date', 2),
(6, 'user', 2),
(7, 'jpp1', 2),
(8, 'jpp1', 2),
(9, 'jpp', 2),
(10, 'OMG c\'est hype long de ouf', 2);

-- --------------------------------------------------------

--
-- Structure de la table `data`
--

DROP TABLE IF EXISTS `data`;
CREATE TABLE IF NOT EXISTS `data` (
  `id` int(11) NOT NULL,
  `valInt` int(11) DEFAULT NULL,
  `valChar` varchar(1000) DEFAULT NULL,
  `idColonne` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idColonne` (`idColonne`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `data`
--

INSERT INTO `data` (`id`, `valInt`, `valChar`, `idColonne`) VALUES
(1, NULL, 'Clement', 1),
(2, NULL, 'BREHARD', 2),
(3, NULL, 'Ranio', 1),
(4, NULL, 'ElBour', 2),
(5, NULL, 'Lucas', 1),
(6, NULL, 'TESSOUILLE', 2),
(7, NULL, 'Sachouille', 1),
(8, NULL, 'LESUEUR', 2);

-- --------------------------------------------------------

--
-- Structure de la table `liste_user`
--

DROP TABLE IF EXISTS `liste_user`;
CREATE TABLE IF NOT EXISTS `liste_user` (
  `idBdd` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`idBdd`,`idUser`),
  KEY `idBdd` (`idBdd`),
  KEY `idUser` (`idUser`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `liste_user`
--

INSERT INTO `liste_user` (`idBdd`, `idUser`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `tab`
--

DROP TABLE IF EXISTS `tab`;
CREATE TABLE IF NOT EXISTS `tab` (
  `id` int(11) NOT NULL,
  `label` varchar(20) DEFAULT NULL,
  `idBdd` int(11) DEFAULT NULL,
  `idUser` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idBdd` (`idBdd`),
  KEY `idUser` (`idUser`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tab`
--

INSERT INTO `tab` (`id`, `label`, `idBdd`, `idUser`) VALUES
(1, 'user', 1, NULL),
(2, 'voitures', 1, NULL),
(3, 'test', 1, NULL),
(4, 'test2', 1, NULL),
(5, 'test3', 1, NULL),
(6, 'test4', 1, NULL),
(7, 'PAS BIEN', 2, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prenom` varchar(30) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `grade` int(11) NOT NULL DEFAULT '0',
  `password` varchar(30) NOT NULL,
  `identifiant` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `prenom`, `nom`, `grade`, `password`, `identifiant`) VALUES
(1, 'aaa', 'aaa', 0, '123', 'aaa'),
(2, 'user2', 'osef', 0, '456', 'bbb');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
