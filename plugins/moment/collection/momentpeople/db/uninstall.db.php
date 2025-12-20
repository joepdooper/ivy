<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;

if(User::canEditAsSuperAdmin()) {
    try {
        DatabaseManager::connection()->exec(
            "
        DROP TABLE `moments_people`;
        "
        );
    } catch (Exception $e) {
        error_log("Failed to drop table 'moments_people': " . $e->getMessage());
    }
    try {
        DatabaseManager::connection()->exec(
            "
        DROP TABLE `people`;
        "
        );
    } catch (Exception $e) {
        error_log("Failed to drop table 'people': " . $e->getMessage());
    }
}