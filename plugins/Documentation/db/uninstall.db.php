<?php
$db->delete(
  'item_template',
  [
    // where
    'plugin_url' => 'Documentation'
  ]
);
$db->exec(
    '
    DROP TABLE `documentation`;
    '
);
?>
