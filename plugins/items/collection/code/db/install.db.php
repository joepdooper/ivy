<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;

if(User::canEditAsSuperAdmin()) {

    try {
        DatabaseManager::connection()->exec('
CREATE TABLE `codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` TEXT NOT NULL,
  `language` varchar(255) DEFAULT NULL,
  `token` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
  '
    );
    } catch (Exception $e) {
        error_log("Failed to create table `codes`: " . $e->getMessage());
    }

    try {
        DatabaseManager::connection()->insert(
            'item_templates',
            [
                // set
                'name' => 'Code',
                'table' => 'code',
                'plugin_url' => 'items/collection/code',
                'route' => 'code',
                'namespace' => 'Items\Collection\Code',
            ]
        );
    } catch (Exception $e) {
        error_log("Failed to insert Code into `item_templates`: " . $e->getMessage());
    }

}