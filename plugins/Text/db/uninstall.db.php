<?php
defined('_BASE_PATH') or die('Something went wrong');

global $db;

$db->delete(
    'item_template',
    [
      // where
        'plugin_url' => 'Text'
    ]
);
$db->exec(
    "
    DROP TABLE `text`;
    "
);
