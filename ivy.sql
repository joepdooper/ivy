# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.44)
# Datenbank: blog
# Erstellt am: 2023-12-01 23:27:07 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Export von Tabelle info
# ------------------------------------------------------------

CREATE TABLE `info` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `bool` tinyint(1) DEFAULT '0',
  `value` varchar(255) DEFAULT NULL,
  `info` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `info` WRITE;
/*!40000 ALTER TABLE `info` DISABLE KEYS */;

INSERT INTO `info` (`id`, `name`, `bool`, `value`, `info`)
VALUES
	(1,'Name',1,'ivy',NULL),
	(2,'Description',1,'Blogging system',NULL),
	(3,'Keywords',1,'CMS, blog',NULL),
	(4,'Language',1,'nl',NULL),
	(5,'Url',1,'http://127.0.0.1/',NULL),
	(6,'Title',1,'ivy',NULL),
	(7,'Date',1,'',NULL),
	(8,'Author',1,'Your name',NULL);

/*!40000 ALTER TABLE `info` ENABLE KEYS */;
UNLOCK TABLES;


# Export von Tabelle option
# ------------------------------------------------------------

CREATE TABLE `option` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `bool` tinyint(1) DEFAULT '0',
  `value` varchar(255) DEFAULT NULL,
  `info` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `option` WRITE;
/*!40000 ALTER TABLE `option` DISABLE KEYS */;

INSERT INTO `option` (`id`, `name`, `bool`, `value`, `info`, `type`)
VALUES
	(1,'Private',0,NULL,'Website only accessible on login','options'),
	(2,'Role registration',0,NULL,'On registration user can set role \'editor\' (coming up)','options'),
	(3,'Minify CSS',0,NULL,'CSS template files as a single minified file','options'),
	(4,'Minify JS',0,NULL,'JS template files as a single minified file','options');

/*!40000 ALTER TABLE `option` ENABLE KEYS */;
UNLOCK TABLES;


# Export von Tabelle plugin
# ------------------------------------------------------------

CREATE TABLE `plugin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `version` varchar(11) NOT NULL DEFAULT '',
  `desc` varchar(255) DEFAULT NULL,
  `folder` varchar(255) NOT NULL DEFAULT '',
  `type` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '0',
  `settings` tinyint(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle profiles
# ------------------------------------------------------------

CREATE TABLE `profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `users_image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle template
# ------------------------------------------------------------

CREATE TABLE `template` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `template` WRITE;
/*!40000 ALTER TABLE `template` DISABLE KEYS */;

INSERT INTO `template` (`id`, `type`, `value`)
VALUES
	(1,'base','base'),
	(2,'sub','DEMO');

/*!40000 ALTER TABLE `template` ENABLE KEYS */;
UNLOCK TABLES;


# Export von Tabelle users
# ------------------------------------------------------------

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(249) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `verified` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `resettable` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `roles_mask` int(10) unsigned NOT NULL DEFAULT '0',
  `registered` int(10) unsigned NOT NULL,
  `last_login` int(10) unsigned DEFAULT NULL,
  `force_logout` mediumint(7) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Export von Tabelle users_confirmations
# ------------------------------------------------------------

CREATE TABLE `users_confirmations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `email` varchar(249) COLLATE utf8mb4_unicode_ci NOT NULL,
  `selector` varchar(16) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `selector` (`selector`),
  KEY `email_expires` (`email`,`expires`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Export von Tabelle users_remembered
# ------------------------------------------------------------

CREATE TABLE `users_remembered` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `selector` varchar(24) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `selector` (`selector`),
  KEY `user` (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Export von Tabelle users_resets
# ------------------------------------------------------------

CREATE TABLE `users_resets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(10) unsigned NOT NULL,
  `selector` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `selector` (`selector`),
  KEY `user_expires` (`user`,`expires`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Export von Tabelle users_throttling
# ------------------------------------------------------------

CREATE TABLE `users_throttling` (
  `bucket` varchar(44) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `tokens` float unsigned NOT NULL,
  `replenished_at` int(10) unsigned NOT NULL,
  `expires_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`bucket`),
  KEY `expires_at` (`expires_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
