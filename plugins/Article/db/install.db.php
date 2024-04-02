<?php
defined('_BASE_PATH') or die('Something went wrong');

global $db;

$db->exec('
CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `subject` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `token` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
  '
);

$db->insert(
  'item_template',
  [
    // set
    'name' => 'Article',
    'table' => 'article',
    'plugin_url' => 'Article',
    'route' => 'article',
    'file' => 'item.php',
  ]
);

$db->insert(
  'tag',
  [
    // set
    'value' => 'Article'
  ]
);
