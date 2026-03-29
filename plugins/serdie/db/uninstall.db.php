<?php

use Ivy\DB;

DB::$connection->exec(
    '
    DROP TABLE `serdie_wordlist`;
    '
);

DB::$connection->exec(
    '
    DROP TABLE `serdie_player`;
    '
);
