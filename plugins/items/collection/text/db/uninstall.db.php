<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;

if(User::canEditAsSuperAdmin()) {
    try {
        DatabaseManager::connection()->delete(
            'item_templates',
            [
                // where
                'plugin_url' => 'text'
            ]
        );
    } catch (Exception $e) {
        error_log($e->getMessage());
    }

    try {
        DatabaseManager::connection()->exec(
            "
        DROP TABLE `texts`;
        "
        );
    } catch (Exception $e) {
        error_log($e->getMessage());
    }
}