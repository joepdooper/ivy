<?php

use Ivy\App;
use Ivy\Model\User;
use Delight\Db\Throwable\Exception;

if (User::canEditAsSuperAdmin()) {
    try {
        App::db()->exec("
            CREATE TABLE `tag` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `value` VARCHAR(255) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
    } catch (Exception $e) {
        error_log("Failed to create table `tag`: " . $e->getMessage());
    }
}
