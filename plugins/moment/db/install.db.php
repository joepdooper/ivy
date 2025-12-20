<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;
use Tags\Tag;

if(User::canEditAsSuperAdmin()) {
    try {
        DatabaseManager::connection()->exec(
            'CREATE TABLE `moments` (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `item_id` int(11) UNSIGNED NOT NULL,
    `title` varchar(255) DEFAULT NULL,
    `token` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`item_id`) REFERENCES `items`(`id`) ON DELETE CASCADE
  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;'
        );
    } catch (Exception $e) {
        error_log("Failed to create table `moments`: " . $e->getMessage());
    }

    $existing = (new Tag)->where('value', 'Moment')->fetchOne();
    if (!$existing) {
        (new Tag)->populate(['value' => 'Moment'])->insert();
    }
}

