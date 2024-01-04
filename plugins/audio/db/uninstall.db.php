<?php
$db->delete(
  'item_template',
  [
    // where
    'plugin_url' => 'Audio'
  ]
);
$db->exec(
    '
    DROP TABLE `audio`;
    '
);
?>
