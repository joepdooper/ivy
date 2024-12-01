<?php

use Ivy\DB;

try {
    DB::$connection->delete(
        'item_template',
        [
            // where
            'plugin_url' => 'Gig'
        ]
    );
} catch (\Delight\Db\Throwable\EmptyWhereClauseError $e) {
}

DB::$connection->exec(
    "
    DROP TABLE `gig`;
    "
);
