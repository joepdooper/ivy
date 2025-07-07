<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;
use Delight\Db\Throwable\Exception;

if (User::canEditAsSuperAdmin()) {

    try {
        DatabaseManager::connection()->exec("
            CREATE TABLE `tags` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `value` VARCHAR(255) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
    } catch (Exception $e) {
        error_log("Failed to create table `tags`: " . $e->getMessage());
    }

    try {
        DatabaseManager::connection()->exec("
            CREATE TABLE `entity_tags` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `tag_id` INT(11) NOT NULL,
                `entity_table` VARCHAR(255) NOT NULL,
                `entity_id` INT NOT NULL,
                UNIQUE KEY unique_tag_entity (tag_id, entity_table, entity_id),
                FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
    } catch (Exception $e) {
        error_log("Failed to create table `entity_tags`: " . $e->getMessage());
    }

}
