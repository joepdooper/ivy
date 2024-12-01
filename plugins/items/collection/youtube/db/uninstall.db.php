<?php

use Delight\Db\Throwable\EmptyWhereClauseError;
use Ivy\DB;

try {
    DB::$connection->delete(
        'item_template',
        [
            // where
            'plugin_url' => 'Youtube'
        ]
    );
} catch (EmptyWhereClauseError $e) {
}

DB::$connection->exec(
    "
    DROP TABLE `youtube`;
    "
);