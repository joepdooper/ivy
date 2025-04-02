<?php

use Ivy\Manager\DatabaseManager;

try {
    DatabaseManager::connection()->delete(
        'item_template',
        [
            // where
            'plugin_url' => 'Vimeo'
        ]
    );
} catch (Exception $e) {
}

try {
    DatabaseManager::connection()->exec(
        "
        DROP TABLE `vimeo`;
        "
    );
} catch (Exception $e) {
}
