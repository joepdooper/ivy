<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;

if(User::canEditAsSuperAdmin()) {

    try {
        DatabaseManager::connection()->exec("
CREATE TABLE `timeline` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime DEFAULT CURRENT_TIMESTAMP,
  `token` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
");
    } catch (Exception $e) {
        error_log($e->getMessage());
    }

    try {
        DatabaseManager::connection()->insert(
            'item_template',
            [
                // set
                'name' => 'Timeline',
                'table' => 'timeline',
                'route' => 'timeline',
                'plugin_url' => 'timeline',
                'namespace' => 'Timeline',
            ]
        );
    } catch (Exception $e) {
        error_log($e->getMessage());
    }

}

