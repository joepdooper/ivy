<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;

if(User::canEditAsSuperAdmin()) {
    try {
        DatabaseManager::connection()->exec("
            CREATE TABLE IF NOT EXISTS `contacts` (
                `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `name` VARCHAR(255) NOT NULL,
                `image` VARCHAR(255) DEFAULT NULL,
                `user_id` VARCHAR(255) DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");
    } catch (Exception $e) {
        error_log("Failed to create table `contacts`: " . $e->getMessage());
    }
}