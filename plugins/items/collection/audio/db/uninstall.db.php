<?php

use Ivy\Manager\DatabaseManager;

try {
    DatabaseManager::connection()->delete(
        'item_template',
        [
            // where
            'plugin_url' => 'audio'
        ]
    );
} catch (Exception $e) {
}

try {
    DatabaseManager::connection()->exec(
        "
    DROP TABLE `audio`;
    "
    );
} catch (Exception $e) {
}