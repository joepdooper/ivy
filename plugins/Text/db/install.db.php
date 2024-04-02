<?php
defined('_BASE_PATH') or die('Something went wrong');

global $db;

$db->exec(
    "
CREATE TABLE `text` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` TEXT NOT NULL,
  `token` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
  "
);

$db->insert(
    'item_template',
    [
      // set
        'name' => 'Text',
        'table' => 'text',
        'route' => 'text',
        'plugin_url' => 'Text',
        'file' => 'item.php',
    ]
);
