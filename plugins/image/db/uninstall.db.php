<?php
$db->delete(
  'item_template',
  [
    // where
    'plugin' => 'image'
  ]
);
$db->exec(
    '
    DROP TABLE `image`;
    '
);
$db->exec(
    '
    DROP TABLE `image_sizes`;
    '
);
?>
