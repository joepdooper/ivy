<?php

use Delight\Db\Throwable\IntegrityConstraintViolationException;
use Ivy\DB;

DB::$connection->exec(
    "
CREATE TABLE `youtube` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `youtube_video_id` varchar(255) DEFAULT NULL,
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
            'name' => 'Youtube',
            'table' => 'youtube',
            'plugin_url' => 'Youtube',
            'route' => 'youtube',
            'file' => 'item.php',
        ]
    );
} catch (IntegrityConstraintViolationException $e) {
}
