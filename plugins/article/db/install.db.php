<?php
$db->exec(
  '
  CREATE TABLE `article` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(255) NOT NULL,
    `subtitle` varchar(255) NOT NULL,
    `subject` int(11) NOT NULL,
    `image` varchar(255) DEFAULT NULL,
    `token` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
    '
  );

    $db->insert(
      'item_template',
      [
        // set
        'plugin' => 'article',
        'table' => 'article',
        'name' => 'article item',
        'item_template_file' => 'item.php',
        'page_template_file' => 'page.php',
      ]
    );

    ?>