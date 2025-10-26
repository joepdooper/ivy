<?php


use Delight\Db\Throwable\IntegrityConstraintViolationException;
use Ivy\DB;

DB::$connection->exec(
    "
CREATE TABLE `bandsintown` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) DEFAULT NULL,
  `artists` varchar(255) DEFAULT NULL,
  `token` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
  "
);

try {
    DB::$connection->insert(
        'bandsintown',
        [
            // set
            'key' => null,
            'artists' => null
        ]
    );
} catch (IntegrityConstraintViolationException $e) {
}