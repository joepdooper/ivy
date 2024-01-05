<?php
$db->delete(
  'item_template',
  [
    // where
    'plugin_url' => 'Text'
  ]
);
$db->exec(
    '
    DROP TABLE `text`;
    '
);
?>
