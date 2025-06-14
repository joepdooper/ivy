<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;

if(User::canEditAsSuperAdmin()) {
    try {
        DatabaseManager::connection()->exec(
            'DROP TABLE `items`;'
        );
    } catch (Exception $e) {
        error_log("Failed to drop table `items`: " . $e->getMessage());
    }

    try {
        DatabaseManager::connection()->exec(
            'DROP TABLE `item_template`;'
        );
    } catch (Exception $e) {
        error_log("Failed to drop table `item_template`: " . $e->getMessage());
    }
}