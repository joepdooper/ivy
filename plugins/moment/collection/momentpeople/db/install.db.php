<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;

if (User::canEditAsSuperAdmin()) {
    try {
        DatabaseManager::connection()->exec('
CREATE TABLE `moments_people` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `moment_id` int(11) NOT NULL,
  `people_id` VARCHAR(255) NOT NULL,
  `token` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
  '
        );
    } catch (Exception $e) {
        error_log('Failed to create table `moments_people`: '.$e->getMessage());
    }
}
