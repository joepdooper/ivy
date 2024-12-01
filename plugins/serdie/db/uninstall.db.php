<?php

\Ivy\DB::$connection->exec(
    "
    DROP TABLE `serdie_wordlist`;
    "
);

\Ivy\DB::$connection->exec(
    "
    DROP TABLE `serdie_player`;
    "
);
