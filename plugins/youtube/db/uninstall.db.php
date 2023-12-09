<?php
$db->delete(
  'item_template',
  [
    // where
    'plugin' => 'youtube'
  ]
);
$db->exec(
    '
    DROP TABLE `youtube`;
    '
);
?>
