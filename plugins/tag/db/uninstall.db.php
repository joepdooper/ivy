<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;

if(User::canEditAsSuperAdmin()) {
    try {
        DatabaseManager::connection()->exec(
            "
        DROP TABLE `tag`;
        "
        );
    } catch (\Delight\Db\Throwable\Exception $e) {
        error_log("Failed to drop table `tag`: " . $e->getMessage());
    }
}