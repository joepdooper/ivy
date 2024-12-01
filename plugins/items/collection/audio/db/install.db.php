<?php

use Ivy\DB;
use Ivy\Message;

try {
    DB::$connection->exec(
        "
CREATE TABLE `audio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` varchar(255) DEFAULT NULL,
  `token` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
  "
    );
} catch (Exception $e) {
    Message::add($e->getMessage());
}

try {
    DB::$connection->insert(
        'item_template',
        [
            // set
            'name' => 'Audio',
            'table' => 'audio',
            'plugin_url' => 'audio',
            'route' => 'audio',
            'namespace' => 'Audio',
        ]
    );
} catch (Exception $e) {
    Message::add($e->getMessage());
}