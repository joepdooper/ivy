<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;
use Delight\Db\Throwable\Exception;

if (User::canEditAsSuperAdmin()) {

    try {
        DatabaseManager::connection()->exec("
            DROP TABLE IF EXISTS `contacts`;
        ");
    } catch (Exception $e) {
        error_log("Failed to drop table `contacts`: " . $e->getMessage());
    }

}