<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;

if(User::canEditAsSuperAdmin()) {

    try {
        DatabaseManager::connection()->exec(
            "
CREATE TABLE `youtubes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `youtube_video_id` varchar(255) DEFAULT NULL,
  `token` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
  "
        );
    } catch (Exception $e) {
        error_log("Failed to create table `youtubes`: " . $e->getMessage());
    }

    try {
        DatabaseManager::connection()->insert(
            'item_templates',
            [
                // set
                'name' => 'Youtube',
                'table' => 'youtube',
                'plugin_url' => 'items/collection/youtube',
                'route' => 'youtube',
                'namespace' => 'Items\Collection\Youtube',
            ]
        );
    } catch (Exception $e) {
        error_log("Failed to insert Youtube into `item_templates`: " . $e->getMessage());
    }
}