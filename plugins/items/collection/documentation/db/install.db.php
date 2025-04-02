<?php

use Ivy\Manager\DatabaseManager;

DatabaseManager::connection()->exec(
    "
CREATE TABLE `documentation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `item_template_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `subject` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `token` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
  "
);

try {
    DatabaseManager::connection()->insert(
        'item_template',
        [
            // set
            'name' => 'Documentation',
            'table' => 'documentation',
            'plugin_url' => 'items/collection/documentation',
            'route' => 'documentation',
            'namespace' => 'Documentation',
        ]
    );
} catch (Exception $e) {
}

try {
    DatabaseManager::connection()->insert(
        'tag',
        [
            // set
            'value' => 'Documentation'
        ]
    );
} catch (Exception $e) {
}