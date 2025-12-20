<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;

if(User::canEditAsSuperAdmin()) {

    try {
        DatabaseManager::connection()->exec(
            "
CREATE TABLE `audios` (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `item_id` int(11) UNSIGNED NOT NULL,
    `file` varchar(255) DEFAULT NULL,
    `token` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`item_id`) REFERENCES `items`(`id`) ON DELETE CASCADE
  ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
  "
        );
    } catch (Exception $e) {
        error_log("Failed to create table `audios`: " . $e->getMessage());
    }

    try {
        DatabaseManager::connection()->insert(
            'item_templates',
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
        error_log("Failed to insert Audio into `item_templates`: " . $e->getMessage());
    }

}