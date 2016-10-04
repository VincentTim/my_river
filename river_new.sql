-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 04 Octobre 2016 à 10:59
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `river_new`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Contenu de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Illustration'),
(2, 'Photographie');

-- --------------------------------------------------------

--
-- Structure de la table `file`
--

CREATE TABLE IF NOT EXISTS `file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT NULL,
  `file` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8C9F36104B89032C` (`post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Contenu de la table `file`
--

INSERT INTO `file` (`id`, `post_id`, `file`) VALUES
(1, 1, '3c07f84a7bedd8b4c73179612791f3795b8cbae9.jpeg'),
(2, 2, '8244a6b3107d489f4c5863badd988b94d9978cd7.jpeg'),
(3, 3, '16f62dbb22dda679e819c7b117477edc17f5e949.jpeg'),
(4, 4, 'aea6717a13dbc97a887455bf078172f83444abda.jpeg'),
(5, 5, '2602f26464a29f9c158e766c905d7f7f8012f128.jpeg'),
(6, 6, 'ec55b7554ccbfeea2c5d4bac3e91863964a13d1d.jpeg');

-- --------------------------------------------------------

--
-- Structure de la table `fos_user`
--

CREATE TABLE IF NOT EXISTS `fos_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_957A647992FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_957A6479A0D96FBF` (`email_canonical`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `fos_user`
--

INSERT INTO `fos_user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`) VALUES
(1, 'Vincent', 'vincent', 'rougiervincent@gmail.com', 'rougiervincent@gmail.com', 1, 'sz3lb71bk5wo8o0wocg8w4oww4kkss4', '$2y$13$sz3lb71bk5wo8o0wocg8wuz/q75JvhwU.2EDYjjQL45VWUKrG4ywK', '2016-10-03 21:31:26', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:16:"ROLE_SUPER_ADMIN";}', 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `creation` datetime NOT NULL,
  `modification` datetime NOT NULL,
  `excerpt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `view` int(11) DEFAULT '0',
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_5A8A6C8D2B36786B` (`title`),
  UNIQUE KEY `UNIQ_5A8A6C8D989D9B62` (`slug`),
  KEY `IDX_5A8A6C8D12469DE2` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Contenu de la table `post`
--

INSERT INTO `post` (`id`, `category_id`, `title`, `creation`, `modification`, `excerpt`, `description`, `view`, `slug`) VALUES
(1, 1, 'Fushimi Inari Taisha', '2016-10-03 21:39:22', '2016-10-03 21:39:22', 'Fushimi Inari Taisha', '<p>&nbsp;Fushimi Inari Taisha</p>', 2, 'fushimi-inari-taisha'),
(2, 1, 'hAndy', '2016-10-03 21:55:45', '2016-10-03 21:55:45', 'hAndy', '<p>hAndy</p>', 4, 'handy'),
(3, 2, 'Toulouse on Wheel', '2012-07-15 22:16:00', '2012-07-15 22:16:00', 'Toulouse on Wheel', '<p>Toulouse on Wheel</p>', 1, 'toulouse-on-wheel'),
(4, 2, 'Lyon X Rousse', '2016-10-03 22:19:31', '2016-10-03 22:19:31', 'Lyon X Rousse', '<p>Lyon X Rousse</p>', 4, 'lyon-x-rousse'),
(5, 1, 'Mc Biohazard', '2016-10-03 22:30:14', '2016-10-03 22:30:14', 'Mc Biohazard', '<p>Mc Biohazard</p>', 1, 'mc-biohazard'),
(6, 2, 'LuftHansa', '2016-10-03 22:39:47', '2016-10-03 22:41:36', 'LuftHansa', '<p>LuftHansa</p>', 2, 'lufthansa');

-- --------------------------------------------------------

--
-- Structure de la table `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `tag_post`
--

CREATE TABLE IF NOT EXISTS `tag_post` (
  `tag_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`tag_id`,`post_id`),
  KEY `IDX_B485D33BBAD26311` (`tag_id`),
  KEY `IDX_B485D33B4B89032C` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `file`
--
ALTER TABLE `file`
  ADD CONSTRAINT `FK_8C9F36104B89032C` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`);

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `FK_5A8A6C8D12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Contraintes pour la table `tag_post`
--
ALTER TABLE `tag_post`
  ADD CONSTRAINT `FK_B485D33B4B89032C` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_B485D33BBAD26311` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
