<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;

if(User::canEditAsSuperAdmin()) {

    try {
        DatabaseManager::connection()->exec(
            "
        DROP TABLE `tags`;
        "
        );
    } catch (\Delight\Db\Throwable\Exception $e) {
        error_log("Failed to drop table `tags`: " . $e->getMessage());
    }

    try {
        DatabaseManager::connection()->exec(
            "
        DROP TABLE `entity_tags`;
        "
        );
    } catch (\Delight\Db\Throwable\Exception $e) {
        error_log("Failed to drop table `entity_tags`: " . $e->getMessage());
    }

}