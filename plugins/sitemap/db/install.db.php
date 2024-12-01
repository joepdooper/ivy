<?php


\Ivy\DB::$connection->exec(
    "
CREATE TABLE `sitemap` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bool` tinyint(1) DEFAULT '0',
  `url` varchar(255) DEFAULT NULL,
  `token` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
  "
);

\Ivy\DB::$connection->insert(
    'sitemap',
    [
        // set
        'bool' => '1',
        'url' => _ROOT . _SUBFOLDER . 'sitemap.xml'
    ]
);