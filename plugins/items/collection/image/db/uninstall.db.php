<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;

if(User::canEditAsSuperAdmin()) {

    try {
        DatabaseManager::connection()->delete(
            'item_templates',
            [
                // where
                'plugin_url' => 'image'
            ]
        );
    } catch (Exception $e) {
        error_log("Failed to remove image from item_templates: " . $e->getMessage());
    }

    try {
        DatabaseManager::connection()->exec(
            "
        DROP TABLE `images`;
        "
        );
    } catch (Exception $e) {
        error_log("Failed to drop table `images`: " . $e->getMessage());
    }

    try {
        DatabaseManager::connection()->exec(
            "
        DROP TABLE `image_sizes`;
        "
        );
    } catch (Exception $e) {
        error_log("Failed to drop table `image_sizes`: " . $e->getMessage());
    }
}