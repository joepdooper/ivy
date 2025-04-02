<?php

use Ivy\Manager\DatabaseManager;

try {
    DatabaseManager::connection()->exec(
        "
    CREATE TABLE `vimeo` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `vimeo_video_id` varchar(255) DEFAULT NULL,
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
            'name' => 'Vimeo',
            'table' => 'vimeo',
            'plugin_url' => 'items/collection/vimeo',
            'route' => 'vimeo',
            'namespace' => 'Vimeo',
        ]
    );
} catch (Exception $e) {
}