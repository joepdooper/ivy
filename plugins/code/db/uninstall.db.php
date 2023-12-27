<?php
$db->delete(
  'item_template',
  [
    // where
    'plugin' => 'code'
  ]
);
$db->exec(
    '
    DROP TABLE `code`;
    '
);
?>
