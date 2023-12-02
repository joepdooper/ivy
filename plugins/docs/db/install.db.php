<?php
$db->exec(
  '
  CREATE TABLE `docs` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `item_id` int(11) DEFAULT NULL,
    `item_template_id` int(11) DEFAULT NULL,
    `title` varchar(255) NOT NULL,
    `subtitle` varchar(255) NOT NULL,
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
      'plugin' => 'docs',
      'table' => 'docs',
      'name' => 'docs item',
      'item_template_file' => 'item.php',
      'page_template_file' => 'page.php',
    ]
  );

  ?>
