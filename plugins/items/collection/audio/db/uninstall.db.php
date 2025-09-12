<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;

if(User::canEditAsSuperAdmin()) {

    try {
        DatabaseManager::connection()->delete(
            'item_templates',
            [
                // where
                'plugin_url' => 'audio'
            ]
        );
    } catch (Exception $e) {
        error_log("Failed to remove audio from item_templates: " . $e->getMessage());
    }

    try {
        DatabaseManager::connection()->exec(
            "
    DROP TABLE `audios`;
    "
        );
    } catch (Exception $e) {
        error_log("Failed to drop table `audios`: " . $e->getMessage());
    }
}