/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Export von Tabelle article
# ------------------------------------------------------------

DROP TABLE IF EXISTS `article`;

CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `subject` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `token` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle audio
# ------------------------------------------------------------

DROP TABLE IF EXISTS `audio`;

CREATE TABLE `audio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` varchar(255) DEFAULT NULL,
  `token` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle docs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `docs`;

CREATE TABLE `docs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `item_template_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `subject` int(11) NOT NULL,
  `token` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle image
# ------------------------------------------------------------

DROP TABLE IF EXISTS `image`;

CREATE TABLE `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` varchar(255) DEFAULT NULL,
  `token` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle image_sizes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `image_sizes`;

CREATE TABLE `image_sizes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `bool` tinyint(1) DEFAULT '0',
  `value` int(11) DEFAULT NULL,
  `info` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `image_sizes` WRITE;
/*!40000 ALTER TABLE `image_sizes` DISABLE KEYS */;

INSERT INTO `image_sizes` (`id`, `name`, `bool`, `value`, `info`)
VALUES
	(1,'original',1,NULL,NULL),
	(2,'large',1,1320,NULL),
	(3,'small',1,640,NULL),
	(4,'thumb',1,200,NULL),
	(5,'icon',1,60,NULL);

/*!40000 ALTER TABLE `image_sizes` ENABLE KEYS */;
UNLOCK TABLES;


# Export von Tabelle info
# ------------------------------------------------------------

DROP TABLE IF EXISTS `info`;

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
	(5,'Url',1,'http://localhost:8888/blog/',NULL),
	(6,'Title',1,'ivy',NULL),
	(7,'Date',1,'',NULL),
	(8,'Author',1,'Name',NULL);

/*!40000 ALTER TABLE `info` ENABLE KEYS */;
UNLOCK TABLES;


# Export von Tabelle item_template
# ------------------------------------------------------------

DROP TABLE IF EXISTS `item_template`;

CREATE TABLE `item_template` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `plugin` varchar(255) DEFAULT NULL,
  `table` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `item_template_file` varchar(255) DEFAULT NULL,
  `page_template_file` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `item_template` WRITE;
/*!40000 ALTER TABLE `item_template` DISABLE KEYS */;

INSERT INTO `item_template` (`id`, `plugin`, `table`, `name`, `item_template_file`, `page_template_file`)
VALUES
	(1,'image','image','image item','item.php',''),
	(2,'text','text','text item','item.php',''),
	(3,'article','article','article item','item.php','page.php'),
	(4,'audio','audio','audio item','item.php',''),
	(5,'docs','docs','docs item','item.php','page.php'),
	(6,'youtube','youtube','youtube item','item.php',''),
	(7,'vimeo','vimeo','vimeo item','item.php','');

/*!40000 ALTER TABLE `item_template` ENABLE KEYS */;
UNLOCK TABLES;


# Export von Tabelle items
# ------------------------------------------------------------

DROP TABLE IF EXISTS `items`;

CREATE TABLE `items` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL,
  `template` int(11) DEFAULT NULL,
  `published` int(11) DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  `token` int(11) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sort` int(11) DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `postid` (`table_id`),
  KEY `userid` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle option
# ------------------------------------------------------------

DROP TABLE IF EXISTS `option`;

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

DROP TABLE IF EXISTS `plugin`;

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

LOCK TABLES `plugin` WRITE;
/*!40000 ALTER TABLE `plugin` DISABLE KEYS */;

INSERT INTO `plugin` (`id`, `name`, `version`, `desc`, `folder`, `type`, `active`, `settings`)
VALUES
	(81,'Overlay mode','1.0.0','Overlay mode','mode-overlay','template',1,0),
	(82,'Dark mode','1.0.0','Dark mode','mode-dark','template',1,0),
	(84,'Tag','1.0.0','Create tags for items','tag','filter',1,1),
	(85,'Image','1.0.0','Image item','image','item',1,1),
	(86,'Text','1.0.0','Text item','text','item',1,0),
	(87,'Article','1.0.0','Article item','article','item',1,0),
	(88,'Audio','1.0.0','Audio item','audio','item',1,0),
	(91,'Docs','1.0.0','Docs item','docs','item',1,0),
	(94,'Youtube','1.0.0','Youtube player','youtube','item',0,0),
	(95,'Vimeo','1.0.0','Vimeo SDK','vimeo','item',0,0);

/*!40000 ALTER TABLE `plugin` ENABLE KEYS */;
UNLOCK TABLES;


# Export von Tabelle profiles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `profiles`;

CREATE TABLE `profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `users_image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `profiles` WRITE;
/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;

INSERT INTO `profiles` (`id`, `user_id`, `users_image`)
VALUES
	(1,1,NULL);

/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;
UNLOCK TABLES;


# Export von Tabelle tag
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tag`;

CREATE TABLE `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `tag` WRITE;
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;

INSERT INTO `tag` (`id`, `value`)
VALUES
	(1,'Getting started'),
	(2,'The basics'),
	(3,'Database'),
	(4,'Packages');

/*!40000 ALTER TABLE `tag` ENABLE KEYS */;
UNLOCK TABLES;


# Export von Tabelle template
# ------------------------------------------------------------

DROP TABLE IF EXISTS `template`;

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


# Export von Tabelle text
# ------------------------------------------------------------

DROP TABLE IF EXISTS `text`;

CREATE TABLE `text` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(255) NOT NULL,
  `token` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

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

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `email`, `password`, `username`, `status`, `verified`, `resettable`, `roles_mask`, `registered`, `last_login`, `force_logout`)
VALUES
	(1,'admin@localhost.test','$2y$10$MPCNqwvXNzBK.Ip5PYhgGOkdzY.NrWgnvk.oz9RrEg0UmLKGnlpfu','ivy',0,1,1,263169,1701517536,1701537675,0);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;


# Export von Tabelle users_confirmations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users_confirmations`;

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

DROP TABLE IF EXISTS `users_remembered`;

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

DROP TABLE IF EXISTS `users_resets`;

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

DROP TABLE IF EXISTS `users_throttling`;

CREATE TABLE `users_throttling` (
  `bucket` varchar(44) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `tokens` float unsigned NOT NULL,
  `replenished_at` int(10) unsigned NOT NULL,
  `expires_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`bucket`),
  KEY `expires_at` (`expires_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Export von Tabelle vimeo
# ------------------------------------------------------------

DROP TABLE IF EXISTS `vimeo`;

CREATE TABLE `vimeo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vimeo_video_id` varchar(255) DEFAULT NULL,
  `token` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle youtube
# ------------------------------------------------------------

DROP TABLE IF EXISTS `youtube`;

CREATE TABLE `youtube` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `youtube_video_id` varchar(255) DEFAULT NULL,
  `token` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
