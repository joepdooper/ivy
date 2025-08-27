<?php

use Ivy\Manager\DatabaseManager;
use Delight\Db\Throwable\Exception;

try {
    DatabaseManager::connection()->exec("
        CREATE TABLE IF NOT EXISTS `articles` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
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

try {
    DatabaseManager::connection()->insert(
        'item_templates',
        [
            'name' => 'Article',
            'table' => 'article',
            'plugin_url' => 'items/collection/article',
            'route' => 'article',
            'namespace' => 'Items\Collection\Article',
        ]
    );
} catch (Exception $e) {
    error_log("Failed to insert into `item_templates`: " . $e->getMessage());
}

try {
    $existing = DatabaseManager::connection()->select('tags', ['value' => 'Article'])->fetch();
    if (!$existing) {
        DatabaseManager::connection()->insert('tags', ['value' => 'Article']);
    }
} catch (Exception $e) {
    error_log("Failed to insert tag 'Article': " . $e->getMessage());
}
