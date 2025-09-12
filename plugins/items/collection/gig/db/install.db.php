<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;
use Tags\Tag;

if(User::canEditAsSuperAdmin()) {

    try{
        DatabaseManager::connection()->exec(
        "
  CREATE TABLE `gigs` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `datetime` datetime DEFAULT CURRENT_TIMESTAMP,
    `venue` varchar(255) DEFAULT NULL,
    `address` varchar(255) DEFAULT NULL,
    `latitude` int(11) DEFAULT NULL,
    `longitude` int(11) DEFAULT NULL,
    `price` decimal(8, 2) DEFAULT NULL,
    `url` varchar(255) DEFAULT NULL,
    `subject` int(11) NOT NULL,
    `token` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
    "
        );
    } catch (Exception $e) {
        error_log("Failed to create table `gigs`: " . $e->getMessage());
    }

    try {
        DatabaseManager::connection()->insert(
            'item_templates',
            [
                // set
                'name' => 'Gig',
                'table' => 'gig',
                'plugin_url' => 'items/collection/gig',
                'route' => 'gig',
                'namespace' => 'Items\Collection\Gig',
            ]
        );
    } catch (Exception $e) {
        error_log("Failed to insert Gig into `item_templates`: " . $e->getMessage());
    }

    $existing = (new Tag)->where('value', 'Gig')->fetchOne();
    if (!$existing) {
        (new Tag)->populate(['value' => 'Gig'])->insert();
    }
}