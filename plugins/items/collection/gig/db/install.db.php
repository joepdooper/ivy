<?php

use Ivy\Manager\DatabaseManager;

DatabaseManager::connection()->exec(
    "
  CREATE TABLE `gig` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `datetime` datetime DEFAULT CURRENT_TIMESTAMP,
    `venue` varchar(255) DEFAULT NULL,
    `address` varchar(255) DEFAULT NULL,
    `latitude` int(11) DEFAULT NULL,
    `longitude` int(11) DEFAULT NULL,
    `price` decimal(8, 2) DEFAULT NULL,
    `url` varchar(255) DEFAULT NULL,
    `subject` int(11) NOT NULL,
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
            'name' => 'Gig',
            'table' => 'gig',
            'plugin_url' => 'items/collection/gig',
            'route' => 'gig',
            'namespace' => 'Gig',
        ]
    );
} catch (Exception $e) {
}

try {
    DatabaseManager::connection()->insert(
        'tag',
        [
            // set
            'value' => 'Gig'
        ]
    );
} catch (Exception $e) {
}