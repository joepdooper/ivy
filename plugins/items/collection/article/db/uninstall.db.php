<?php

use Ivy\Manager\DatabaseManager;

try {
    DatabaseManager::connection()->delete(
        'item_template',
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
        DROP TABLE `article`;
        '
    );
} catch (Exception $e) {
}
