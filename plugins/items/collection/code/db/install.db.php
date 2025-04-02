<?php

use Delight\Db\Throwable\IntegrityConstraintViolationException;
use Ivy\Manager\DatabaseManager;

DatabaseManager::connection()->exec('
CREATE TABLE `code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` TEXT NOT NULL,
  `language` varchar(255) DEFAULT NULL,
  `token` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
  '
);

try {
    DatabaseManager::connection()->insert(
        'item_template',
        [
            // set
            'name' => 'Code',
            'table' => 'code',
            'plugin_url' => 'items/collection/code',
            'route' => 'code',
            'namespace' => 'Code',
        ]
    );
} catch (IntegrityConstraintViolationException $e) {
}
