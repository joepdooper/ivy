<?php

use Ivy\Manager\DatabaseManager;

try {
    DatabaseManager::connection()->exec(
        'DROP TABLE `items`;'
    );
} catch (Exception $e) {
}

try {
    DatabaseManager::connection()->exec(
        'DROP TABLE `item_template`;'
    );
} catch (Exception $e) {
}