<?php

use Ivy\DB;

try {
    DB::getConnection()->exec(
        "
        DROP TABLE `tag`;
        "
    );
} catch (Exception $e) {
    Message::add($e->getMessage());
}