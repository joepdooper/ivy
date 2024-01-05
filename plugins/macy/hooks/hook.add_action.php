<?php
defined('_BASE_PATH') or die('Something went wrong');

function add_macy_js(){
  global $page;
  $page->addJS("node_modules/macy/dist/macy.js");
  $page->addJS("plugins/macy/js/macy-init.js");
}

$hooks->add_action('add_js_action','add_macy_js');
?>
