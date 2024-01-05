<?php
$db->delete(
  'item_template',
  [
    // where
    'plugin_url' => 'Article'
  ]
);
$db->exec(
    '
    DROP TABLE `article`;
    '
);
?>
