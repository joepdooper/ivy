<?php
$db->delete(
  'item_template',
  [
    // where
    'plugin_url' => 'Code'
  ]
);
$db->exec(
    '
    DROP TABLE `code`;
    '
);
?>
