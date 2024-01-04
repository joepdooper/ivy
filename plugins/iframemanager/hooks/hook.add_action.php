<?php
defined('_BASE_PATH') or die('Something went wrong');

function add_iframemanager_css(){
  global $page;
  $page->addCSS("node_modules/@orestbida/iframemanager/dist/iframemanager.css");
}

function add_iframemanager_js(){
  global $page;
  $page->addJS("node_modules/@orestbida/iframemanager/dist/iframemanager.js");
  $page->addJS("plugins/iframemanager/js/iframemanager-init.js");
}

$hooks->add_action('add_css_action','add_iframemanager_css');
$hooks->add_action('add_js_action','add_iframemanager_js');
?>
