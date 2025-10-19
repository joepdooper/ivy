<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;

if(User::canEditAsSuperAdmin()) {
    try {
        DatabaseManager::connection()->exec(
            "
        DROP TABLE `moments_date_time`;
        "
        );
    } catch (Exception $e) {
        error_log("Failed to drop table 'moments_date_time': " . $e->getMessage());
    }
}