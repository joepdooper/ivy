<?php
$db->delete(
  'item_template',
  [
    // where
    'plugin' => 'text'
  ]
);
$db->exec(
    '
    DROP TABLE `text`;
    '
);
?>
