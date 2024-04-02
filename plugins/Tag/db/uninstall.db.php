<?php
defined('_BASE_PATH') or die('Something went wrong');

global $db;

$db->exec(
    "
    DROP TABLE `tag`;
    "
);

$db->exec(
    "
    DROP TABLE `item_tag`;
    "
);