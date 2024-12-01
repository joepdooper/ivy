<?php

use Ivy\DB;
use Ivy\Message;

try {
    DB::$connection->exec(
        'CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `subject` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `token` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;'
    );
} catch (Exception $e) {
    Message::add($e->getMessage());
}

try {
    DB::$connection->insert(
        'item_template',
        [
            // set
            'name' => 'Article',
            'table' => 'article',
            'plugin_url' => 'article',
            'route' => 'article',
            'namespace' => 'Article',
        ]
    );
} catch (Exception $e) {
    Message::add($e->getMessage());
}

try {
    DB::$connection->insert(
        'tag',
        [
            // set
            'value' => 'Article'
        ]
    );
} catch (Exception $e) {
    Message::add($e->getMessage());
}
