<?php
$db->delete(
  'item_template',
  [
    // where
    'plugin' => 'audio'
  ]
);
$db->exec(
    '
    DROP TABLE `audio`;
    '
);
?>
