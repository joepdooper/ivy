<?php
$db->exec(
  '
  CREATE TABLE `code` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `code` TEXT NOT NULL,
    `language` varchar(255) DEFAULT NULL,
    `token` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
    '
  );

    $db->insert(
      'item_template',
      [
        // set
        'plugin' => 'code',
        'table' => 'code',
        'name' => 'code item',
        'item_template_file' => 'item.php',
        'page_template_file' => '',
      ]
    );

    ?>
