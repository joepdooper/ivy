<?php
$db->delete(
  'item_template',
  [
    // where
    'plugin_url' => 'Gig'
  ]
);
$db->exec(
    '
    DROP TABLE `gig`;
    '
);
?>
