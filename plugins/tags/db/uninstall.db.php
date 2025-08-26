<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;
use Delight\Db\Throwable\Exception;

if (User::canEditAsSuperAdmin()) {

    try {
        DatabaseManager::connection()->exec("
            DROP TABLE IF EXISTS `entity_tags`;
        ");
    } catch (Exception $e) {
        error_log("Failed to drop table `entity_tags`: " . $e->getMessage());
    }

    try {
        DatabaseManager::connection()->exec("
            DROP TABLE IF EXISTS `tags`;
        ");
    } catch (Exception $e) {
        error_log("Failed to drop table `tags`: " . $e->getMessage());
    }

}