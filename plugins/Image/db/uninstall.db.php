<?php
defined('_BASE_PATH') or die('Something went wrong');

global $db;

$db->delete(
    'item_template',
    [
      // where
        'plugin_url' => 'Image'
    ]
);
$db->exec(
    "
    DROP TABLE `image`;
    "
);
$db->exec(
    "
    DROP TABLE `image_sizes`;
    "
);
