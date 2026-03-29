<?php

use Delight\Db\Throwable\Exception;
use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;

if (User::canEditAsSuperAdmin()) {

    try {
        DatabaseManager::connection()->exec('
            DROP TABLE IF EXISTS `contacts`;
        ');
    } catch (Exception $e) {
        error_log('Failed to drop table `contacts`: '.$e->getMessage());
    }

}
