<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;

if(User::canEditAsSuperAdmin()) {

    try {
        DatabaseManager::connection()->delete(
            'item_templates',
            [
                // where
                'plugin_url' => 'youtube'
            ]
        );
    } catch (Exception $e) {
        error_log("Failed to remove youtube from item_templates: " . $e->getMessage());
    }

    try{
        DatabaseManager::connection()->exec(
        "
    DROP TABLE `youtubes`;
    "
    );
    } catch (Exception $e) {
        error_log("Failed to drop table `youtubes`: " . $e->getMessage());
    }
}