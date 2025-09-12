<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;

if(User::canEditAsSuperAdmin()) {

    try {
        DatabaseManager::connection()->delete(
            'item_templates',
            [
                // where
                'plugin_url' => 'documentation'
            ]
        );
    } catch (Exception $e) {
        error_log("Failed to remove documentation from item_templates: " . $e->getMessage());
    }

    try{
    DatabaseManager::connection()->exec(
        "
    DROP TABLE `documentations`;
    "
    );
    } catch (Exception $e) {
        error_log("Failed to drop table `documentations`: " . $e->getMessage());
    }
}