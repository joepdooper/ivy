<?php

use Delight\Db\Throwable\IntegrityConstraintViolationException;
use Ivy\DB;

DB::$connection->exec(
    "
CREATE TABLE `documentation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `item_template_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `subject` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
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
            'name' => 'Documentation',
            'table' => 'documentation',
            'plugin_url' => 'Documentation',
            'route' => 'documentation',
            'file' => 'item.php',
        ]
    );
} catch (IntegrityConstraintViolationException $e) {
}

try {
    DB::$connection->insert(
        'tag',
        [
            // set
            'value' => 'Documentation'
        ]
    );
} catch (IntegrityConstraintViolationException $e) {
}