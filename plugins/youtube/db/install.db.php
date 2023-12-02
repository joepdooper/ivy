<?php
$db->exec(
  '
  CREATE TABLE `youtube` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `youtube_video_id` varchar(255) DEFAULT NULL,
    `token` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
    '
  );

    $db->insert(
      'item_template',
      [
        // set
        'plugin' => 'youtube',
        'table' => 'youtube',
        'name' => 'youtube item',
        'item_template_file' => 'item.php',
        'page_template_file' => '',
      ]
    );

    ?>
