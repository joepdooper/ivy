<?php

use Ivy\DB;

DB::$connection->exec(
    "
    DROP TABLE `bandsintown`;
    "
);