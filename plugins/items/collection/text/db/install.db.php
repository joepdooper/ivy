<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;

if(User::canEditAsSuperAdmin()) {

    DatabaseManager::connection()->exec(
        "
CREATE TABLE `texts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` TEXT NOT NULL,
  `token` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
  "
    );

    try {
        DatabaseManager::connection()->insert(
            'item_templates',
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
        error_log($e->getMessage());
    }
}