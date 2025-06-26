<?php

use Ivy\Manager\DatabaseManager;

try {
    DatabaseManager::connection()->delete(
        'item_templates',
        [
            // where
            'plugin_url' => 'image'
        ]
    );
} catch (Exception $e) {
}

try {
    DatabaseManager::connection()->exec(
        "
        DROP TABLE `images`;
        "
    );
} catch (Exception $e) {
}

try {
    DatabaseManager::connection()->exec(
        "
        DROP TABLE `image_sizes`;
        "
    );
} catch (Exception $e) {
}
