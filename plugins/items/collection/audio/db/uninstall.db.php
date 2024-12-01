<?php

use Ivy\DB;
use Ivy\Message;

try {
    DB::$connection->delete(
        'item_template',
        [
            // where
            'plugin_url' => 'audio'
        ]
    );
} catch (Exception $e) {
    Message::add($e->getMessage());
}

try {
    DB::$connection->exec(
        "
    DROP TABLE `audio`;
    "
    );
} catch (Exception $e) {
    Message::add($e->getMessage());
}