<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;

if(User::canEditAsSuperAdmin()) {

    try{
    DatabaseManager::connection()->exec(
        "
CREATE TABLE `moments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `token` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
  "
    );
    } catch (Exception $e) {
        error_log("Failed to create table `moments`: " . $e->getMessage());
    }

    try {
        DatabaseManager::connection()->insert(
            'item_templates',
            [
                // set
                'name' => 'Moment',
                'table' => 'moments',
                'route' => 'moment',
                'plugin_url' => 'items/collection/moment',
                'namespace' => 'Items\Collection\Moment',
            ]
        );
    } catch (Exception $e) {
        error_log("Failed to insert Moment into `item_templates`: " . $e->getMessage());
    }
}