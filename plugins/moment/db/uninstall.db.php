<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;
use Ivy\Core\Path;

if(User::canEditAsSuperAdmin()) {
    try {
        DatabaseManager::connection()->delete(
            'item_templates',
            [
                // where
                'plugin_url' => 'moment'
            ]
        );
    } catch (Exception $e) {
        error_log("Failed to remove 'Moment' from item_templates: " . $e->getMessage());
    }

    try {
        DatabaseManager::connection()->exec(
            'DROP TABLE `moments`;'
        );
    } catch (Exception $e) {
        error_log("Failed to drop table `moments`: " . $e->getMessage());
    }
}