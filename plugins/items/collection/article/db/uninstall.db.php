<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;

if(User::canEditAsSuperAdmin()) {

    try {
        DatabaseManager::connection()->delete(
            'item_templates',
            [
                // where
                'plugin_url' => 'article'
            ]
        );
    } catch (Exception $e) {
        error_log("Failed to remove article from item_templates: " . $e->getMessage());
    }

    try {
        DatabaseManager::connection()->exec(
            '
        DROP TABLE `articles`;
        '
        );
    } catch (Exception $e) {
        error_log("Failed to drop table `articles`: " . $e->getMessage());
    }

}