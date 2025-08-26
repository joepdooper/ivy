<?php

use Ivy\Manager\DatabaseManager;

DatabaseManager::connection()->exec(
    "
CREATE TABLE `documentations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `subject` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `token` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
  "
);

try {
    DatabaseManager::connection()->insert(
        'item_templates',
        [
            // set
            'name' => 'Documentation',
            'table' => 'documentation',
            'plugin_url' => 'items/collection/documentation',
            'route' => 'documentation',
            'namespace' => 'Items\Collection\Documentation',
        ]
    );
} catch (Exception $e) {
}

try {
    DatabaseManager::connection()->insert(
        'tags',
        [
            // set
            'value' => 'Documentation'
        ]
    );
} catch (Exception $e) {
}