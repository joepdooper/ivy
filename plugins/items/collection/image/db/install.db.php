<?php


use Delight\Db\Throwable\IntegrityConstraintViolationException;
use Ivy\DB;

DB::$connection->exec(
    "
CREATE TABLE `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` varchar(255) DEFAULT NULL,
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
            'name' => 'Image',
            'table' => 'image',
            'plugin_url' => 'image',
            'route' => 'image',
            'namespace' => 'Image',
        ]
    );
} catch (IntegrityConstraintViolationException $e) {
}

DB::$connection->exec(
    "
CREATE TABLE `image_sizes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255),
  `bool` tinyint(1) DEFAULT 0,
  `value` int(11) DEFAULT NULL,
  `info` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
  "
);

try {
    DB::$connection->insert(
        'image_sizes',
        [
            // set
            'name' => 'original',
            'bool' => '1',
            'value' => NULL
        ]
    );
} catch (IntegrityConstraintViolationException $e) {
}

try {
    DB::$connection->insert(
        'image_sizes',
        [
            // set
            'name' => 'large',
            'bool' => '1',
            'value' => '1320'
        ]
    );
} catch (IntegrityConstraintViolationException $e) {
}

try {
    DB::$connection->insert(
        'image_sizes',
        [
            // set
            'name' => 'small',
            'bool' => '1',
            'value' => '640'
        ]
    );
} catch (IntegrityConstraintViolationException $e) {
}

try {
    DB::$connection->insert(
        'image_sizes',
        [
            // set
            'name' => 'thumb',
            'bool' => '1',
            'value' => '200'
        ]
    );
} catch (IntegrityConstraintViolationException $e) {
}

try {
    DB::$connection->insert(
        'image_sizes',
        [
            // set
            'name' => 'icon',
            'bool' => '1',
            'value' => '60'
        ]
    );
} catch (IntegrityConstraintViolationException $e) {
}