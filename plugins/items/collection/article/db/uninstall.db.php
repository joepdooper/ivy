<?php

use Ivy\Manager\DatabaseManager;

try {
    DatabaseManager::connection()->delete(
        'item_templates',
        [
            // where
            'plugin_url' => 'article'
        ]
    );
} catch (Exception $e) {
}

try {
    DatabaseManager::connection()->exec(
        '
        DROP TABLE `articles`;
        '
    );
} catch (Exception $e) {
}
