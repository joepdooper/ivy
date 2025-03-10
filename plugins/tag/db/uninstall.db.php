<?php

use Ivy\DB;
use Ivy\Message;

try {
    DB::getConnection()->exec(
        "
        DROP TABLE `tag`;
        "
    );
} catch (Exception $e) {
    Message::add($e->getMessage());
}

try {
    DB::getConnection()->exec(
        "
        DROP TABLE `item_tag`;
        "
    );
} catch (Exception $e) {
    Message::add($e->getMessage());
}