<?php
$db->exec(
  '
  CREATE TABLE `text` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `text` TEXT NOT NULL,
    `token` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
    '
  );

    $db->insert(
      'item_template',
      [
        // set
        'plugin' => 'text',
        'table' => 'text',
        'name' => 'text item',
        'item_template_file' => 'item.php',
        'page_template_file' => '',
      ]
    );

    ?>
