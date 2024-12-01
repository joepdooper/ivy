<?php

use Delight\Db\Throwable\IntegrityConstraintViolationException;
use Ivy\DB;
use Ivy\Message;

DB::$connection->exec(
    "
CREATE TABLE `text` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` TEXT NOT NULL,
  `token` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
  "
);

try {
    DB::$connection->insert(
        'item_template',
        [
            // set
            'name' => 'Text',
            'table' => 'text',
            'route' => 'text',
            'plugin_url' => 'text',
            'namespace' => 'Text',
        ]
    );
} catch (IntegrityConstraintViolationException $e) {
    Message::add($e->getMessage());
}
