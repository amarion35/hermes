-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1:3307
-- Généré le :  Mar 25 Avril 2017 à 13:06
-- Version du serveur :  5.6.34-log
-- Version de PHP :  7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `hermes`
--

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `ID` text,
  `Login` text,
  `Mot_de_passe` text,
  `Mail` text,
  `Age` tinyint(4) DEFAULT NULL,
  `Date_inscription` datetime DEFAULT CURRENT_TIMESTAMP,
  `Pseudo` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`ID`, `Login`, `Mot_de_passe`, `Mail`, `Age`, `Date_inscription`, `Pseudo`) VALUES
('#1', 'Bob', 'Bob', 'Bob', 1, '2017-04-25 10:56:34', 'Bob'),
('#2', 'Alice', 'Alice', 'Alice', 1, '2017-04-25 10:56:34', 'Alice'),
('#3', 'Eve', 'Eve', 'Eve', 1, '2017-04-25 11:00:15', 'Eve'),
('#4', 'Jean', 'Jean', 'Jean', 2, '2017-04-25 11:00:15', 'Jean'),
('#0', 'Admin', 'Admin', 'Admin', 0, '2017-04-25 11:05:35', 'Admin');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
