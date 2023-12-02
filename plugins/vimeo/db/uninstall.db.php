<?php
$db->delete(
  'item_template',
  [
    // where
    'plugin' => 'vimeo'
  ]
);
$db->exec(
    '
    DROP TABLE `vimeo`;
    '
);
?>
