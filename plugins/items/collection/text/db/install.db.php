<?php

use Ivy\Manager\DatabaseManager;

DatabaseManager::connection()->exec(
    "
CREATE TABLE `text` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` TEXT NOT NULL,
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
            'name' => 'Text',
            'table' => 'text',
            'route' => 'text',
            'plugin_url' => 'items/collection/text',
            'namespace' => 'Items\Collection\Text',
        ]
    );
} catch (Exception $e) {
}
