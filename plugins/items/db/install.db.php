<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;
use Ivy\Core\Path;

if(User::canEditAsSuperAdmin()) {
    try {
        DatabaseManager::connection()->exec(
            'CREATE TABLE IF NOT EXISTS `items` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` int(11) DEFAULT NULL,
    `parent_id` int(11) DEFAULT NULL,
    `publish` int(11) DEFAULT NULL,
    `token` int(11) DEFAULT NULL,
    `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `sort` int(11) DEFAULT NULL,
    `slug` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `userid` (`user_id`)
                     ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;'
        );
    } catch (Exception $e) {
        error_log("Failed to create table `items`: " . $e->getMessage());
    }

    $mediaPath = Path::get('MEDIA_PATH') . 'items';
    if (!file_exists($mediaPath)) {
        mkdir($mediaPath, 0755, true);
        file_put_contents("$mediaPath/.htaccess", "Options -Indexes\n<FilesMatch \"\.(php|php5|phtml|js)$\">\nDeny from all\n</FilesMatch>");
        file_put_contents("$mediaPath/index.php", "<?php // Silence is golden");
    }
}

