<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;
use Ivy\Core\Path;
use Tags\Tag;

if(User::canEditAsSuperAdmin()) {
    try {
        DatabaseManager::connection()->exec(
            'CREATE TABLE `moments` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `title` varchar(255) DEFAULT NULL,
    `token` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;'
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
                'plugin_url' => 'moment',
                'namespace' => 'Moment',
            ]
        );
    } catch (Exception $e) {
        error_log("Failed to insert Moment into `item_templates`: " . $e->getMessage());
    }

    $existing = (new Tag)->where('value', 'Moment')->fetchOne();
    if (!$existing) {
        (new Tag)->populate(['value' => 'Moment'])->insert();
    }
}

