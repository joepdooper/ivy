<?php
$db->delete(
  'item_template',
  [
    // where
    'plugin_url' => 'Youtube'
  ]
);
$db->exec(
    '
    DROP TABLE `youtube`;
    '
);
?>
