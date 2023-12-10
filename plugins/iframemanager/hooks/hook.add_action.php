<?php
defined('_BASE_PATH') or die('Something went wrong');

function add_iframemanager_css(){
  print "<link rel='stylesheet' href='https://cdn.jsdelivr.net/gh/orestbida/iframemanager@1.2.5/dist/iframemanager.css'>";
}

function add_iframemanager_js(){
  print "<script src='https://cdn.jsdelivr.net/gh/orestbida/iframemanager@1.2.5/dist/iframemanager.js'></script>";
  global $page;
  $page->addJS("plugins/iframemanager/js/iframemanager-init.js");
}

$hooks->add_action('add_css_action','add_iframemanager_css');
$hooks->add_action('add_js_action','add_iframemanager_js');
?>
