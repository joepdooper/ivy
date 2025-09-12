<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;

if(User::canEditAsSuperAdmin()) {

    try {
        DatabaseManager::connection()->delete(
            'item_templates',
            [
                // where
                'plugin_url' => 'gig'
            ]
        );
    } catch (Exception $e) {
        error_log("Failed to remove gig from item_templates: " . $e->getMessage());
    }

    try{
        DatabaseManager::connection()->exec(
        "
    DROP TABLE `gigs`;
    "
        );
    } catch (Exception $e) {
        error_log("Failed to drop table `gigs`: " . $e->getMessage());
    }

}