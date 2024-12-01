<?php

use Ivy\DB;
use Ivy\Message;

try {
    DB::$connection->delete(
        'item_template',
        [
            // where
            'plugin_url' => 'Vimeo'
        ]
    );
} catch (Exception $e) {
    Message::add($e->getMessage());
}

try {
    DB::$connection->exec(
        "
        DROP TABLE `vimeo`;
        "
    );
} catch (Exception $e) {
    Message::add($e->getMessage());
}
