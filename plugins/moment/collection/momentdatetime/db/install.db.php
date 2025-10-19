<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;
use Tags\Tag;

if(User::canEditAsSuperAdmin()) {

    try{
    DatabaseManager::connection()->exec(
        "
CREATE TABLE `moments_date_time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `moment_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `token` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
  "
    );
    } catch (Exception $e) {
        error_log("Failed to create table `moments_date_time`: " . $e->getMessage());
    }
}