<?php
$db->delete(
  'item_template',
  [
    // where
    'plugin' => 'gig'
  ]
);
$db->exec(
    '
    DROP TABLE `gig`;
    '
);
?>
