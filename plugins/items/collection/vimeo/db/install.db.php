<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;

if(User::canEditAsSuperAdmin()) {
    try {
        DatabaseManager::connection()->exec(
            "
    CREATE TABLE `vimeos` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `vimeo_video_id` varchar(255) DEFAULT NULL,
      `token` int(11) DEFAULT NULL,
      PRIMARY KEY (`id`)
      ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
      "
        );
    } catch (Exception $e) {
        error_log("Failed to create table `vimeos`: " . $e->getMessage());
    }

    try {
        DatabaseManager::connection()->insert(
            'item_templates',
            [
                // set
                'name' => 'Vimeo',
                'table' => 'vimeo',
                'plugin_url' => 'items/collection/vimeo',
                'route' => 'vimeo',
                'namespace' => 'Items\Collection\Vimeo',
            ]
        );
    } catch (Exception $e) {
        error_log("Failed to insert Vimeo into `item_templates`: " . $e->getMessage());
    }
}