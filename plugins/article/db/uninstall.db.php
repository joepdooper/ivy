<?php
$db->delete(
  'item_template',
  [
    // where
    'plugin' => 'article'
  ]
);
$db->exec(
    '
    DROP TABLE `article`;
    '
);
?>
