<?php

use Ivy\DB;
use Ivy\Message;

try {
    DB::$connection->delete(
        'item_template',
        [
            // where
            'plugin_url' => 'image'
        ]
    );
} catch (Exception $e) {
    Message::add($e->getMessage());
}

try {
    DB::$connection->exec(
        "
        DROP TABLE `image`;
        "
    );
} catch (Exception $e) {
    Message::add($e->getMessage());
}

try {
    DB::$connection->exec(
        "
        DROP TABLE `image_sizes`;
        "
    );
} catch (Exception $e) {
    Message::add($e->getMessage());
}
