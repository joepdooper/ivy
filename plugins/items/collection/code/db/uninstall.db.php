<?php

use Ivy\Manager\DatabaseManager;

try {
    DatabaseManager::connection()->delete(
        'item_template',
        [
            // where
            'plugin_url' => 'Code'
        ]
    );
} catch (Exception $e) {
}

DatabaseManager::connection()->exec(
    "
    DROP TABLE `code`;
    "
);
