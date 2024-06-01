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
  `subject` json NOT NULL,
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



# Export von Tabelle documentation
# ------------------------------------------------------------

DROP TABLE IF EXISTS `documentation`;

CREATE TABLE `documentation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `item_template_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `subject` int(11) NOT NULL,
  `token` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle gig
# ------------------------------------------------------------

DROP TABLE IF EXISTS `gig`;

CREATE TABLE `gig` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime DEFAULT CURRENT_TIMESTAMP,
  `venue` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `latitude` int(11) DEFAULT NULL,
  `longitude` int(11) DEFAULT NULL,
  `price` decimal(8,2) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
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


# Export von Tabelle item_tag
# ------------------------------------------------------------

DROP TABLE IF EXISTS `item_tag`;

CREATE TABLE `item_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle item_template
# ------------------------------------------------------------

DROP TABLE IF EXISTS `item_template`;

CREATE TABLE `item_template` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `table` varchar(255) DEFAULT NULL,
  `plugin_url` varchar(255) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `item_template` WRITE;
/*!40000 ALTER TABLE `item_template` DISABLE KEYS */;

INSERT INTO `item_template` (`id`, `name`, `table`, `plugin_url`, `route`, `file`)
VALUES
	(10,'Text','text','Text','text','item.php'),
	(11,'Image','image','Image','image','item.php'),
	(12,'Audio','audio','Audio','audio','item.php'),
	(14,'Article','article','Article','article','item.php'),
	(16,'Documentation','documentation','Documentation','documentation','item.php'),
	(17,'Gig','gig','Gig','gig','item.php'),
	(18,'Vimeo','vimeo','Vimeo','vimeo','item.php'),
	(19,'Youtube','youtube','Youtube','youtube','item.php');

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
  `style` varchar(255) DEFAULT NULL,
  `position_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `postid` (`table_id`),
  KEY `userid` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Export von Tabelle plugin
# ------------------------------------------------------------

DROP TABLE IF EXISTS `plugin`;

CREATE TABLE `plugin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL,
  `version` varchar(11) NOT NULL DEFAULT '',
  `desc` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '0',
  `settings` tinyint(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `plugin` WRITE;
/*!40000 ALTER TABLE `plugin` DISABLE KEYS */;

INSERT INTO `plugin` (`id`, `name`, `url`, `version`, `desc`, `type`, `active`, `settings`)
VALUES
	(24,'Dark mode','DarkMode','1.0.0','Dark mode','template',1,0),
	(25,'Text','Text','1.0.0','Text item','item',1,0),
	(26,'Image','Image','1.0.0','Image item','item',1,0),
	(28,'Audio','Audio','1.0.0','Audio item','item',1,0),
	(29,'Macy','macy','1.0.0','Macy.js - lightweight, dependency-free, 4kb masonry layout library, designed for a hassle-free configuration','javascript',1,0),
	(33,'Sort item','SortItem','1.0.0','Sort items by drag and drop','template',1,0),
	(34,'Article','Article','1.0.0','Article item','item',1,0),
	(37,'Documentation','Documentation','1.0.0','Documentation item','item',1,0),
	(39,'Gig','Gig','1.0.0','Gig item','item',1,0),
	(40,'Vimeo','Vimeo','1.0.0','Vimeo SDK','item',1,0),
	(41,'Youtube','Youtube','1.0.0','Youtube player','item',1,0),
	(44,'IframeManager','iframemanager','1.0.0','IframeManager from Orest Bida','utility',1,0),
	(45,'Vanilla cookie consent','VanillaCookieConsent','1.0.0','Cookie consent from Orest Bida','utility',1,0),
	(46,'Tag','Tag','1.0.0','Create tags for items','filter',1,1);

/*!40000 ALTER TABLE `plugin` ENABLE KEYS */;
UNLOCK TABLES;


# Export von Tabelle position
# ------------------------------------------------------------

DROP TABLE IF EXISTS `position`;

CREATE TABLE `position` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `value` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `position` WRITE;
/*!40000 ALTER TABLE `position` DISABLE KEYS */;

INSERT INTO `position` (`id`, `value`)
VALUES
	(1,'intro');

/*!40000 ALTER TABLE `position` ENABLE KEYS */;
UNLOCK TABLES;


# Export von Tabelle profiles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `profiles`;

CREATE TABLE `profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `users_image` varchar(255) DEFAULT NULL,
  `last_activity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `profiles` WRITE;
/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;

INSERT INTO `profiles` (`id`, `user_id`, `users_image`, `last_activity`)
VALUES
	(1,1,NULL,'2024-03-16 18:12:17');

/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;
UNLOCK TABLES;


# Export von Tabelle setting
# ------------------------------------------------------------

DROP TABLE IF EXISTS `setting`;

CREATE TABLE `setting` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `bool` tinyint(1) NOT NULL DEFAULT '0',
  `value` varchar(255) DEFAULT NULL,
  `info` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `setting` WRITE;
/*!40000 ALTER TABLE `setting` DISABLE KEYS */;

INSERT INTO `setting` (`id`, `name`, `bool`, `value`, `info`)
VALUES
	(1,'Private',0,'','Website only accessible on login'),
	(2,'Minify CSS',0,'','CSS template files as a single minified file'),
	(3,'Minify JS',0,'','JS template files as a single minified file'),
	(4,'Registration role',0,'EDITOR','Set automatic role after user registration'),
	(5,'Name',1,'ivy','Meta name'),
	(6,'Title',1,'ivy','Meta title'),
	(7,'Description',1,'Yet another sleek simple fast CMS with an effortless template and plugin environment','Meta description'),
	(8,'Keywords',1,'fast, CMS, design, build, simple, slim, clean, easy, quick, cms-framework, content-management-system, google-page-speed, easy-to-deploy ','Meta keywords'),
	(9,'Url',1,'http://localhost:8888/blog/','Meta url'),
	(10,'Language',1,'en_GB','Meta language'),
	(11,'Author',1,'Joep Dooper','Meta author'),
	(12,'Created',1,'2024-01-01','Meta created'),
	(13,'Available',1,'2024-01-01','Meta available'),
	(14,'Updated',1,'2024-01-01','Meta updated');

/*!40000 ALTER TABLE `setting` ENABLE KEYS */;
UNLOCK TABLES;


# Export von Tabelle tag
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tag`;

CREATE TABLE `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `tag` WRITE;
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;

INSERT INTO `tag` (`id`, `value`)
VALUES
	(8,'Article'),
	(9,'Documentation'),
	(10,'Gig');

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
  `text` text NOT NULL,
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
