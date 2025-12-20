<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;

if(User::canEditAsSuperAdmin()) {
    try{
    DatabaseManager::connection()->exec(
        'CREATE TABLE `images` (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `item_id` int(11) UNSIGNED NOT NULL,
    `file` varchar(255) DEFAULT NULL,
    `token` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`item_id`) REFERENCES `items`(`id`) ON DELETE CASCADE
  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;'
    );
    } catch (Exception $e) {
        error_log("Failed to create table `images`: " . $e->getMessage());
    }

    try{
    DatabaseManager::connection()->exec(
        "
CREATE TABLE `image_sizes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255),
  `bool` tinyint(1) DEFAULT 0,
  `value` int(11) DEFAULT NULL,
  `info` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
  "
    );
    } catch (Exception $e) {
        error_log("Failed to create table `image_sizes`: " . $e->getMessage());
    }

    try {
        DatabaseManager::connection()->insert(
            'image_sizes',
            [
                // set
                'name' => 'original',
                'bool' => '1',
                'value' => NULL
            ]
        );
    } catch (Exception $e) {
        error_log("Failed to insert into `image_sizes`: " . $e->getMessage());
    }

    try {
        DatabaseManager::connection()->insert(
            'image_sizes',
            [
                // set
                'name' => 'large',
                'bool' => '1',
                'value' => '1320'
            ]
        );
    } catch (Exception $e) {
        error_log("Failed to insert into `image_sizes`: " . $e->getMessage());
    }

    try {
        DatabaseManager::connection()->insert(
            'image_sizes',
            [
                // set
                'name' => 'small',
                'bool' => '1',
                'value' => '640'
            ]
        );
    } catch (Exception $e) {
        error_log("Failed to insert into `image_sizes`: " . $e->getMessage());
    }

    try {
        DatabaseManager::connection()->insert(
            'image_sizes',
            [
                // set
                'name' => 'thumb',
                'bool' => '1',
                'value' => '200'
            ]
        );
    } catch (Exception $e) {
        error_log("Failed to insert into `image_sizes`: " . $e->getMessage());
    }

    try {
        DatabaseManager::connection()->insert(
            'image_sizes',
            [
                // set
                'name' => 'icon',
                'bool' => '1',
                'value' => '60'
            ]
        );
    } catch (Exception $e) {
        error_log("Failed to insert into `image_sizes`: " . $e->getMessage());
    }
}