<?php

use Ivy\Manager\DatabaseManager;

DatabaseManager::connection()->exec(
    "
CREATE TABLE `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` varchar(255) DEFAULT NULL,
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
            'name' => 'Image',
            'table' => 'image',
            'plugin_url' => 'items/collection/image',
            'route' => 'image',
            'namespace' => 'Items\Collection\Image',
        ]
    );
} catch (Exception $e) {
}

DatabaseManager::connection()->exec(
    "
CREATE TABLE `image_sizes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255),
  `bool` tinyint(1) DEFAULT 0,
  `value` int(11) DEFAULT NULL,
  `info` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
  "
);

try {
    DatabaseManager::connection()->insert(
        'image_sizes',
        [
            // set
            'name' => 'original',
            'bool' => '1',
            'value' => NULL
        ]
    );
} catch (Exception $e) {
}

try {
    DatabaseManager::connection()->insert(
        'image_sizes',
        [
            // set
            'name' => 'large',
            'bool' => '1',
            'value' => '1320'
        ]
    );
} catch (Exception $e) {
}

try {
    DatabaseManager::connection()->insert(
        'image_sizes',
        [
            // set
            'name' => 'small',
            'bool' => '1',
            'value' => '640'
        ]
    );
} catch (Exception $e) {
}

try {
    DatabaseManager::connection()->insert(
        'image_sizes',
        [
            // set
            'name' => 'thumb',
            'bool' => '1',
            'value' => '200'
        ]
    );
} catch (Exception $e) {
}

try {
    DatabaseManager::connection()->insert(
        'image_sizes',
        [
            // set
            'name' => 'icon',
            'bool' => '1',
            'value' => '60'
        ]
    );
} catch (Exception $e) {
}