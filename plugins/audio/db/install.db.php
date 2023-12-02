<?php
$db->exec(
  '
  CREATE TABLE `audio` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `file` varchar(255) DEFAULT NULL,
    `token` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
    '
  );

    $db->insert(
      'item_template',
      [
        // set
        'plugin' => 'audio',
        'table' => 'audio',
        'name' => 'audio item',
        'item_template_file' => 'item.php',
        'page_template_file' => '',
      ]
    );

    ?>
