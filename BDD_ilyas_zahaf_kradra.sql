-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 20 fév. 2023 à 20:04
-- Version du serveur :  8.0.21
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `mi5`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `visuel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `texte` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `libelle`, `visuel`, `texte`) VALUES
(1, 'Fruits', 'images/categories/fruits.jpg', 'De la passion ou de ton imagination'),
(2, 'Légumes', 'images/categories/legumes.jpg', 'Plus tu en manges, moins tu en es un'),
(3, 'Junk Food', 'images/categories/junk_food.jpg', 'Chère et cancérogène, tu es prévenu(e)'),
(4, 'Virus', 'images/categories/corona.jpg', 'Une opportunité, il faut en profiter');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usager_id` int NOT NULL,
  `date_commande` date NOT NULL,
  `statut` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` double NOT NULL,
  `nb_produit` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6EEAA67D4F36F0FC` (`usager_id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id`, `usager_id`, `date_commande`, `statut`, `total`, `nb_produit`) VALUES
(35, 3, '2023-02-18', 'Terminée', 2.5, 1),
(36, 3, '2023-02-18', 'En cours', 2.5, 1),
(46, 8, '2023-02-19', 'En cours', 21, 1),
(47, 3, '2023-02-19', 'En cours', 21, 1),
(48, 3, '2023-02-19', 'En cours', 13.5, 3),
(49, 3, '2023-02-19', 'En cours', 29.25, 2),
(50, 3, '2023-02-19', 'En cours', 21, 1),
(53, 14, '2023-02-19', 'En cours', 15.25, 3),
(54, 3, '2023-02-20', 'En cours', 7, 2),
(55, 2, '2023-02-20', 'En cours', 200, 1),
(59, 3, '2023-02-20', 'En cours', 200, 1),
(60, 3, '2023-02-20', 'En cours', 200, 1),
(61, 3, '2023-02-20', 'En cours', 200, 1),
(62, 2, '2023-02-20', 'En cours', 4.5, 1),
(63, 2, '2023-02-20', 'En cours', 4.5, 1);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20230119145944', '2023-01-19 15:00:13', 723),
('DoctrineMigrations\\Version20230120084549', '2023-01-31 13:06:03', 52),
('DoctrineMigrations\\Version20230120102303', '2023-01-31 13:06:03', 192),
('DoctrineMigrations\\Version20230131133416', '2023-01-31 13:34:34', 71),
('DoctrineMigrations\\Version20230131133808', '2023-01-31 13:38:18', 44),
('DoctrineMigrations\\Version20230131133943', '2023-01-31 13:39:51', 43),
('DoctrineMigrations\\Version20230131134147', '2023-01-31 13:41:53', 100),
('DoctrineMigrations\\Version20230131134221', '2023-01-31 13:42:29', 249),
('DoctrineMigrations\\Version20230131145328', '2023-01-31 14:53:32', 202),
('DoctrineMigrations\\Version20230131151524', '2023-01-31 15:15:30', 609),
('DoctrineMigrations\\Version20230131152125', '2023-01-31 15:21:29', 41);

-- --------------------------------------------------------

--
-- Structure de la table `ligne_commande`
--

DROP TABLE IF EXISTS `ligne_commande`;
CREATE TABLE IF NOT EXISTS `ligne_commande` (
  `produit_id` int NOT NULL,
  `commande_id` int NOT NULL,
  `quantite` int NOT NULL,
  `prix` double NOT NULL,
  PRIMARY KEY (`produit_id`,`commande_id`),
  KEY `IDX_3170B74B82EA2E54` (`commande_id`),
  KEY `IDX_3170B74BF347EFB` (`produit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ligne_commande`
--

INSERT INTO `ligne_commande` (`produit_id`, `commande_id`, `quantite`, `prix`) VALUES
(7, 48, 3, 13.5),
(7, 53, 1, 4.5),
(7, 54, 1, 4.5),
(7, 62, 1, 4.5),
(7, 63, 1, 4.5),
(8, 49, 1, 8.25),
(8, 53, 1, 8.25),
(9, 35, 1, 2.5),
(9, 36, 1, 2.5),
(9, 53, 1, 2.5),
(9, 54, 1, 2.5),
(11, 55, 1, 200),
(11, 59, 1, 200),
(11, 60, 1, 200),
(11, 61, 1, 200);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categorie_id` int NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `texte` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `visuel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_29A5EC27BCF5E72D` (`categorie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id`, `categorie_id`, `libelle`, `texte`, `visuel`, `prix`) VALUES
(1, 1, 'Pomme', 'Elle est bonne pour la tienne', 'images/produits/pommes.jpg', 3.42),
(2, 1, 'Poire', 'Ici tu n\'en es pas une', 'images/produits/poires.jpg', 2.11),
(3, 1, 'Pêche', 'Elle va te la donner', 'images/produits/peche.jpg', 2.84),
(4, 2, 'Carotte', 'C\'est bon pour ta vue', 'images/produits/carottes.jpg', 2.9),
(5, 2, 'Tomate', 'Fruit ou Légume ? Légume', 'images/produits/tomates.jpg', 1.7),
(6, 2, 'Chou Romanesco', 'Mange des fractales', 'images/produits/romanesco.jpg', 1.81),
(7, 3, 'Nutella', 'C\'est bon, sauf pour ta santé', 'images/produits/nutella.jpg', 4.5),
(8, 3, 'Pizza', 'Y\'a pas pire que za', 'images/produits/pizza.jpg', 8.25),
(9, 3, 'Oreo', 'Seulement si tu es un smartphone', 'images/produits/oreo.jpg', 2.5),
(10, 4, 'Gel Hydroalcoolique', 'Usage interne ou externe', 'images/produits/gel.jpg', 100),
(11, 4, 'Masque FFP 200', 'Passe incognito face aux virus', 'images/produits/masque.jpg', 200);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `nom`, `prenom`) VALUES
(2, 'admin@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$9n8jDKGYVFhceDFIKrQgYe39do7g025Gp2Zl9TonG8mp9o3IXyXmm', 'NomAdmin', 'PrenomAdmin'),
(3, 'ilyaszahaf2002@gmail.com', '[\"ROLE_CLIENT\"]', '$2y$13$Ngv6s5QXu5T2l/SyAEKn..3wNB61HZTp2NWzkXyz0GgQWUQ03V4Ua', 'ZAHAF KRADRA', 'Ilyas'),
(8, 'orane.doucet@gmail.com', '[\"ROLE_CLIENT\"]', '$2y$13$./YTls8PNX1CKatZIDDeFe6EwI9Y/TJmlsPpRf0VXOSlwydtm14gu', 'test', 'test'),
(9, 'samyzz38@gmail.com', '[\"ROLE_CLIENT\"]', '$2y$13$BOPvRJJPCiW0lZsFj/XfO.xi.wZy4LTlZR7P9PkOHGMOYRvBeedqS', 'zou garry', 'samy'),
(11, 'qqqdoucet@gmail.com', '[\"ROLE_CLIENT\"]', '$2y$13$rJEB20cbv34lZJ.RN/OE7eTDqBCrKH3bCRfLnbyf0k4eY7jmIUHAG', 'ZAHAF KRADRA', 'Ilyas'),
(12, 'ordsdsdane.doucet@gmail.com', '[\"ROLE_CLIENT\"]', '$2y$13$i.2DjT92PvQqiRiPOxA3aOIk8hBvSVZz3Vda3x/v/Jr/GiY2kY8Y2', 'kradra', 'ilyas'),
(13, 'prof.admin@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$CL5NApeceFJCuKcszsPNnez6Xqe.O9cxOvJKC5XeSwMGD.Yn/I9aq', 'Prof', 'admin'),
(14, 'client@gmail.com', '[\"ROLE_CLIENT\"]', '$2y$13$LL3O6iudQ91Iv1AD0JUehegIC3Z8YlLML1DebbUFdclftI3i2q1Qe', 'nomClient', 'client');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `FK_6EEAA67D4F36F0FC` FOREIGN KEY (`usager_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `ligne_commande`
--
ALTER TABLE `ligne_commande`
  ADD CONSTRAINT `FK_3170B74B82EA2E54` FOREIGN KEY (`commande_id`) REFERENCES `commande` (`id`),
  ADD CONSTRAINT `FK_3170B74BF347EFB` FOREIGN KEY (`produit_id`) REFERENCES `produit` (`id`);

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `FK_29A5EC27BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
