-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 25 fév. 2021 à 19:22
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `portfolio`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `date` varchar(255) NOT NULL,
  `idPost` int(11) NOT NULL,
  `validate` varchar(1) NOT NULL DEFAULT 'n',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `author`, `content`, `date`, `idPost`, `validate`) VALUES
(1, 'Tristan Meillat', 'bliablabloy', '18/02/2021', 2, 'y'),
(2, 'Tristan Meillat', 'bliablabloy', '18/02/2021', 2, 'y'),
(3, 'Tristan Meillat', 'bliabla', '18/02/2021', 2, 'n'),
(6, 'Tristan Meillat', 'nytgrf', '18/02/2021', 2, 'n'),
(7, 'Tristan Meillat', 'yjtre', '18/02/2021', 2, 'y'),
(8, 'Tristan Meillat', 'tgrfez', '18/02/2021', 2, 'n'),
(11, 'Tristan Meillat', 'J\'adore cette article ! \r\n\r\n\r\nNam eu mi non odio consequat dignissim. Vestibulum rhoncus ex ac massa eleifend, a feugiat tortor ornare. Etiam elementum mattis ex, sit amet venenatis turpis fermentum sed. Cras tristique lacus ac placerat dignissim. Donec vestibulum justo elit, ac ultrices erat sollicitudin ut. Mauris lobortis, eros nec vehicula tincidunt, ante enim dapibus ex, nec molestie mi ante nec ipsum. Donec condimentum, purus eget pretium convallis, nulla ligula placerat turpis, sit amet gravida elit diam at augue. Sed aliquet luctus diam, suscipit sodales felis euismod quis. ', '23/02/2021', 8, 'y');

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `thumbnail` text NOT NULL,
  `description` text NOT NULL,
  `chapo` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `lastMaj` varchar(50) NOT NULL,
  `dateCreation` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `title`, `thumbnail`, `description`, `chapo`, `author`, `lastMaj`, `dateCreation`) VALUES
(23, 'Mon premier projet : Création d\'un site pour primeur', 'primeur.jpg', 'Dans le cadre d\'un stage, un primeur nous a missionner pour lui créer un site web. Etant donner son budget limité nous avons opté pour du wordpress. Le but était que les client puissent commander et que le primeur puissent validé les commandes dans un back office, cela afin de faciliter son organisation.\r\n\r\nLe projet est finit, mais n\'a jamais été mis en ligne.', 'Un primeur nous a contacté pour réaliser son site web pour simplifié sa gestion !', 'Tristan Meillat', '23/02/2021', '23/02/2021'),
(24, 'Mise en place d\'un site vitrine pour Chalet et Caviar', 'chaletCaviar.jpg', 'Dans la cadre de la formation de développeur d\'application d\'Openclassroom, nous devions réaliser le site vitrine d\'une entreprise fictive de location de chalet avec wordpress. \r\n\r\nLe site est en ligne à cette adresse : http://146.59.226.245/openclassrooms/tm/p2/', 'Second projet dans la cadre de la formation Openclassroom', 'Tristan Meillat', '23/02/2021', '23/02/2021'),
(25, 'Réalisation d\'une maquette pour une festival de cinéma', 'filmPleinAir.jpg', 'Toujours dans le cadre des projets openclassrooms, nous devions réaliser un cahier des charges pour le site d\'un festival de films d\'auteur. Nous devions donc réaliser une maquette qui se trouve ici : http://146.59.226.245/openclassrooms/tm/p3/', 'Venez découvrir ce festival !', 'Tristan Meillat', '23/02/2021', '23/02/2021');

-- --------------------------------------------------------

--
-- Structure de la table `posts_comments`
--

DROP TABLE IF EXISTS `posts_comments`;
CREATE TABLE IF NOT EXISTS `posts_comments` (
  `idPosts` int(11) NOT NULL,
  `idComments` int(11) NOT NULL,
  KEY `idComments` (`idComments`),
  KEY `idPosts` (`idPosts`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `admin` varchar(1) NOT NULL DEFAULT 'n',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `firstname`, `name`, `mail`, `password`, `admin`) VALUES
(1, 'Tristan', 'Meillat', 'tristan.meillat@sfr.fr', '$2y$10$tH.dvy.o8.LbdsnCSbT.P.tOcIfbVqnwY8q2UhSk4Hl6f99DnC0Jq', 'y');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `posts_comments`
--
ALTER TABLE `posts_comments`
  ADD CONSTRAINT `posts_comments_ibfk_1` FOREIGN KEY (`idComments`) REFERENCES `comments` (`id`),
  ADD CONSTRAINT `posts_comments_ibfk_2` FOREIGN KEY (`idPosts`) REFERENCES `posts` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
