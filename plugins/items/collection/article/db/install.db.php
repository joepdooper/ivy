<?php

use Ivy\Manager\DatabaseManager;
use Delight\Db\Throwable\Exception;
use Ivy\Model\User;
use Tags\Tag;

if(User::canEditAsSuperAdmin()) {

    try {
        DatabaseManager::connection()->exec("
        CREATE TABLE IF NOT EXISTS `articles` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `item_id` int(11) UNSIGNED NOT NULL,
            `title` VARCHAR(255) NOT NULL,
            `subtitle` VARCHAR(255) NOT NULL,
            `image` VARCHAR(255) DEFAULT NULL,
            `token` INT(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");
    } catch (Exception $e) {
        error_log("Failed to create table `articles`: " . $e->getMessage());
    }

    $existing = (new Tag)->where('value', 'Article')->fetchOne();
    if (!$existing) {
        (new Tag)->populate(['value' => 'Article'])->insert();
    }

}