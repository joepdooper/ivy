<?php

use Ivy\App;
use Ivy\Model\User;

if(User::canEditAsSuperAdmin()) {
    try {
        App::db()->exec(
            "
        DROP TABLE `tag`;
        "
        );
    } catch (\Delight\Db\Throwable\Exception $e) {
        error_log("Failed to drop table `tag`: " . $e->getMessage());
    }
}