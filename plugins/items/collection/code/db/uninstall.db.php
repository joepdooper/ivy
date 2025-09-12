<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;

if(User::canEditAsSuperAdmin()) {

    try {
        DatabaseManager::connection()->delete(
            'item_templates',
            [
                // where
                'plugin_url' => 'code'
            ]
        );
    } catch (Exception $e) {
        error_log("Failed to remove code from item_templates: " . $e->getMessage());
    }

    try {
        DatabaseManager::connection()->exec(
            "
    DROP TABLE `codes`;
    "
        );
    } catch (Exception $e) {
        error_log("Failed to drop table `codes`: " . $e->getMessage());
    }

}