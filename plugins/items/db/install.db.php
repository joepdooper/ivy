<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;

if(User::canEditAsSuperAdmin()) {
    try {
        DatabaseManager::connection()->exec(
            'CREATE TABLE `items` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL,
    `parent_id` int(11) DEFAULT NULL,
  `template_id` int(11) DEFAULT NULL,
  `published` int(11) DEFAULT NULL,
  `token` int(11) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sort` int(11) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;'
        );
    } catch (Exception $e) {
        error_log("Failed to create table `items`: " . $e->getMessage());
    }

    try {
        DatabaseManager::connection()->exec(
            'CREATE TABLE `item_templates` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `table` varchar(255) DEFAULT NULL,
  `plugin_url` varchar(255) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `namespace` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;'
        );
    } catch (Exception $e) {
        error_log("Failed to create table `item_templates`: " . $e->getMessage());
    }
}

