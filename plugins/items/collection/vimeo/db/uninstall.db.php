<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;

if(User::canEditAsSuperAdmin()) {
    try {
        DatabaseManager::connection()->delete(
            'item_templates',
            [
                // where
                'plugin_url' => 'vimeo'
            ]
        );
    } catch (Exception $e) {
        error_log("Failed to remove vimeo from item_templates: " . $e->getMessage());
    }

    try {
        DatabaseManager::connection()->exec(
            "
        DROP TABLE `vimeos`;
        "
        );
    } catch (Exception $e) {
        error_log("Failed to drop table `vimeos`: " . $e->getMessage());
    }
}