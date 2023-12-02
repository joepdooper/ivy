<?php
$db->delete(
  'item_template',
  [
    // where
    'plugin' => 'docs'
  ]
);
$db->exec(
    '
    DROP TABLE `docs`;
    '
);
?>
