<?php
$db->exec(
  '
  CREATE TABLE `gig` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `datetime` datetime NOT NULL,
    `venue` varchar(255) DEFAULT NULL,
    `address` varchar(255) DEFAULT NULL,
    `latitude` int(11) DEFAULT NULL,
    `longitude` int(11) DEFAULT NULL,
    `price` decimal(8, 2) DEFAULT NULL,
    `url` varchar(255) DEFAULT NULL,
    `subject` int(11) NOT NULL,
    `token` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
    '
  );

  $db->insert(
    'item_template',
    [
      // set
      'plugin' => 'gig',
      'table' => 'gig',
      'name' => 'gig item',
      'item_template_file' => 'item.php',
      'page_template_file' => '',
    ]
  );

  ?>
