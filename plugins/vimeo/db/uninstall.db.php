<?php
$db->delete(
  'item_template',
  [
    // where
    'plugin_url' => 'Vimeo'
  ]
);
$db->exec(
    '
    DROP TABLE `vimeo`;
    '
);
?>
