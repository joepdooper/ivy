<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;
use Tags\Tag;

if(User::canEditAsSuperAdmin()) {

    try{
        DatabaseManager::connection()->exec(
        "
CREATE TABLE `moments_location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `moment_id` int(11) NOT NULL,
  `city` VARCHAR(255) NOT NULL,
  `country` CHAR(255) NOT NULL,
  `country_code` VARCHAR(3) NOT NULL,
  `latitude` DECIMAL(10, 7) NOT NULL,
  `longitude` DECIMAL(10, 7) NOT NULL,
  `token` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
  "
    );
    } catch (Exception $e) {
        error_log("Failed to create table `moments_location`: " . $e->getMessage());
    }

    $existing = (new Tag)->where('value', 'Moment')->fetchOne();
    if (!$existing) {
        (new Tag)->populate(['value' => 'Moment'])->insert();
    }
}