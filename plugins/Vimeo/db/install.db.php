<?php
$db->exec(
    "
CREATE TABLE `vimeo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vimeo_video_id` varchar(255) DEFAULT NULL,
  `token` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
  "
);

$db->insert(
    'item_template',
    [
      // set
        'name' => 'Vimeo',
        'table' => 'vimeo',
        'plugin_url' => 'Vimeo',
        'route' => 'vimeo',
        'file' => 'item.php',
    ]
);