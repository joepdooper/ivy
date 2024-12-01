<?php

use Ivy\DB;
use Ivy\Message;

try {
    DB::$connection->exec(
        '
        DROP TABLE `items`;
        '
    );
} catch (Exception $e) {
    Message::add($e->getMessage());
}

try {
    DB::$connection->exec(
        '
        DROP TABLE `item_template`;
        '
    );
} catch (Exception $e) {
    Message::add($e->getMessage());
}