<?php

use Ivy\Manager\DatabaseManager;

try {
    DatabaseManager::connection()->delete(
        'item_template',
        [
            // where
            'plugin_url' => 'text'
        ]
    );
} catch (Exception $e) {
}

try {
    DatabaseManager::connection()->exec(
        "
        DROP TABLE `text`;
        "
    );
} catch (Exception $e) {
}