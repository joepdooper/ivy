<?php

use Ivy\DB;
use Ivy\Message;

try {
    DB::$connection->exec(
        'CREATE TABLE `items` (
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
  `slug` varchar(255) DEFAULT NULL,
  `position_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;'
    );
} catch (Exception $e) {
    Message::add($e->getMessage());
}

try {
    DB::$connection->exec(
        'CREATE TABLE `item_template` (
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
    Message::add($e->getMessage());
}