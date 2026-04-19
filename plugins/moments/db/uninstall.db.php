<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;

if (User::canEditAsSuperAdmin()) {
    try {
        DatabaseManager::connection()->exec(
            'ALTER TABLE `profiles`
    DROP COLUMN `birthday`;'
        );
    } catch (Exception $e) {
        error_log('Failed to remove column `birthday`: ' . $e->getMessage());
    }

    try {
        DatabaseManager::connection()->exec(
            'DROP TABLE `moments`;'
        );
    } catch (Exception $e) {
        error_log('Failed to drop table `moments`: '.$e->getMessage());
    }
}
