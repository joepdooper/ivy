<?php
defined('_BASE_PATH') or die('Something went wrong');

global $db;

$db->exec(
    "
CREATE TABLE `audio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` varchar(255) DEFAULT NULL,
  `token` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
  "
);

$db->insert(
    'item_template',
    [
      // set
        'name' => 'Audio',
        'table' => 'audio',
        'plugin_url' => 'Audio',
        'route' => 'audio',
        'file' => 'item.php',
    ]
);