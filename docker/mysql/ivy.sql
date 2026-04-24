/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


DROP TABLE IF EXISTS `infos`;
CREATE TABLE `infos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `info` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `plugin_id` int DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `plugins`;
CREATE TABLE `plugins` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int DEFAULT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL,
  `namespace` varchar(255) DEFAULT NULL,
  `version` varchar(11) NOT NULL DEFAULT '',
  `description` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `profiles`;
CREATE TABLE `profiles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `user_image` varchar(255) DEFAULT NULL,
  `last_activity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `bool` tinyint(1) NOT NULL DEFAULT '0',
  `value` varchar(255) DEFAULT NULL,
  `info` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `plugin_id` int DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `templates`;
CREATE TABLE `templates` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(249) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint unsigned NOT NULL DEFAULT '0',
  `verified` tinyint unsigned NOT NULL DEFAULT '0',
  `resettable` tinyint unsigned NOT NULL DEFAULT '1',
  `roles_mask` int unsigned NOT NULL DEFAULT '0',
  `registered` int unsigned NOT NULL,
  `last_login` int unsigned DEFAULT NULL,
  `force_logout` mediumint unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `users_confirmations`;
CREATE TABLE `users_confirmations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `email` varchar(249) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `selector` varchar(16) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `selector` (`selector`),
  KEY `email_expires` (`email`,`expires`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `users_remembered`;
CREATE TABLE `users_remembered` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int unsigned NOT NULL,
  `selector` varchar(24) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `selector` (`selector`),
  KEY `user` (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `users_resets`;
CREATE TABLE `users_resets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int unsigned NOT NULL,
  `selector` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `selector` (`selector`),
  KEY `user_expires` (`user`,`expires`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `users_throttling`;
CREATE TABLE `users_throttling` (
  `bucket` varchar(44) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `tokens` float unsigned NOT NULL,
  `replenished_at` int unsigned NOT NULL,
  `expires_at` int unsigned NOT NULL,
  PRIMARY KEY (`bucket`),
  KEY `expires_at` (`expires_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `infos` (`id`, `name`, `value`, `info`, `token`, `plugin_id`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'Name', 'localhost', 'Website name', NULL, NULL, 1, NULL, NULL),
(2, 'Title', 'ivy', 'Meta title', NULL, NULL, 1, NULL, NULL),
(3, 'Description', 'Yet another sleek simple fast CMS with an effortless template and plugin environment', 'Meta description', NULL, NULL, 1, NULL, NULL),
(4, 'Keywords', 'fast, CMS, design, build, simple, slim, clean, easy, quick, cms-framework, content-management-system, google-page-speed, easy-to-deploy', 'Meta keywords', NULL, NULL, 1, NULL, '2026-04-24 00:02:07'),
(5, 'Url', 'http://localhost:8888/blog/', 'Meta url', NULL, NULL, 1, NULL, NULL),
(6, 'Language', 'en_GB', 'Meta language', NULL, NULL, 1, NULL, NULL),
(7, 'Author', 'Joep Dooper', 'Meta author', NULL, NULL, 1, NULL, NULL),
(8, 'Created', '2024-01-01', 'Meta created date', NULL, NULL, 1, NULL, NULL),
(9, 'Available', '2024-01-01', 'Meta available date', NULL, NULL, 1, NULL, NULL),
(10, 'Updated', '2024-01-01', 'Meta updated date', NULL, NULL, 1, NULL, NULL);

INSERT INTO `profiles` (`id`, `user_id`, `user_image`, `last_activity`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, '2025-01-01 12:00:00', NULL, NULL);

INSERT INTO `settings` (`id`, `name`, `bool`, `value`, `info`, `token`, `plugin_id`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'Private', 0, '', 'Set website to private', NULL, NULL, 1, NULL, NULL),
(2, 'Minify CSS', 0, '', 'CSS minifier', NULL, NULL, 1, NULL, NULL),
(3, 'Minify JS', 0, '', 'JS minifier', NULL, NULL, 1, NULL, NULL),
(4, 'Registration role', 0, 'EDITOR', 'After registration set user role', NULL, NULL, 1, NULL, NULL),
(11, 'Sort', 0, NULL, 'Sort items by drag and drop', NULL, 37, 0, NULL, NULL),
(12, 'Timeline', 0, NULL, 'Show items in a timeline', NULL, 37, 0, NULL, NULL),
(13, 'Sort', 0, NULL, 'Sort items by drag and drop', NULL, 38, 0, NULL, NULL),
(14, 'Timeline', 0, NULL, 'Show items in a timeline', NULL, 38, 0, NULL, NULL),
(17, 'Sort', 0, NULL, 'Sort items by drag and drop', NULL, 49, 0, NULL, NULL),
(18, 'Timeline', 0, NULL, 'Show items in a timeline', NULL, 49, 0, NULL, NULL),
(19, 'Sort', 0, NULL, 'Sort items by drag and drop', NULL, 50, 0, NULL, NULL),
(20, 'Timeline', 0, NULL, 'Show items in a timeline', NULL, 50, 0, NULL, NULL);

INSERT INTO `templates` (`id`, `type`, `value`, `created_at`, `updated_at`) VALUES
(1, 'base', 'base', NULL, NULL),
(2, 'sub', 'DEMO', NULL, NULL);

INSERT INTO `users` (`id`, `email`, `password`, `username`, `status`, `verified`, `resettable`, `roles_mask`, `registered`, `last_login`, `force_logout`) VALUES
(1, 'admin@localhost.test', '$2y$12$ILvFcrz1kxPnAlwr6fFa4OWTW7EeDK5Uf1KFgdSFCzkXpxL5miV5C', 'ivy', 0, 1, 1, 263169, 1701517536, 1776988916, 0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;