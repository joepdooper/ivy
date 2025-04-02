<?php

use Ivy\Manager\DatabaseManager;

try {
    DatabaseManager::connection()->delete(
        'item_template',
        [
            // where
            'plugin_url' => 'Documentation'
        ]
    );
} catch (Exception $e) {
}

DatabaseManager::connection()->exec(
    "
    DROP TABLE `documentation`;
    "
);
