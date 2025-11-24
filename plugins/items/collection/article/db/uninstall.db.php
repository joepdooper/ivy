<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;

if(User::canEditAsSuperAdmin()) {

    try {
        DatabaseManager::connection()->exec(
            '
        DROP TABLE `articles`;
        '
        );
    } catch (Exception $e) {
        error_log("Failed to drop table `articles`: " . $e->getMessage());
    }

}