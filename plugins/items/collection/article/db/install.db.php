<?php

use Ivy\Manager\DatabaseManager;

try {
    DatabaseManager::connection()->exec(
        'CREATE TABLE `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `subject` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `token` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;'
    );
} catch (Exception $e) {
}

try {
    DatabaseManager::connection()->insert(
        'item_templates',
        [
            // set
            'name' => 'Article',
            'table' => 'article',
            'plugin_url' => 'items/collection/article',
            'route' => 'article',
            'namespace' => 'Items\Collection\Article',
        ]
    );
} catch (Exception $e) {
}

try {
    DatabaseManager::connection()->insert(
        'tags',
        [
            // set
            'value' => 'Article'
        ]
    );
} catch (Exception $e) {
}
