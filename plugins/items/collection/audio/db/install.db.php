<?php

use Ivy\Manager\DatabaseManager;

try {
    DatabaseManager::connection()->exec(
        "
CREATE TABLE `audio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` varchar(255) DEFAULT NULL,
  `token` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
  "
    );
} catch (Exception $e) {
}

try {
    DatabaseManager::connection()->insert(
        'item_template',
        [
            // set
            'name' => 'Audio',
            'table' => 'audio',
            'plugin_url' => 'items/collection/audio',
            'route' => 'audio',
            'namespace' => 'Items\Collection\Audio',
        ]
    );
} catch (Exception $e) {
}