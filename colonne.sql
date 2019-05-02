-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 02 mai 2019 à 14:15
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
  PRIMARY KEY (`id`),
  KEY `idTab` (`idTab`)
) ENGINE=MyISAM AUTO_INCREMENT=113 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `colonne`
--

INSERT INTO `colonne` (`id`, `label`, `description`, `idTab`, `type`, `A_I`) VALUES
(108, 'telephone', '', 103, 'Nombre', 0),
(107, 'adresse', 'adresse de l\'utilisateur', 103, 'Texte', 0),
(106, 'prenom', 'prenom de l\'utilisateur', 103, 'Texte', 0),
(104, 'id', 'id de l\'utilisateur', 103, 'Nombre', 0),
(105, 'nom', 'nom de l\'utilisateur', 103, 'Texte', 0),
(109, 'a', 'a', 105, 'Texte', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
