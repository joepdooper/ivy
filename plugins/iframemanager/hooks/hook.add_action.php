<?php
defined('_BASE_PATH') or die('Something went wrong');

function add_iframemanager_css(){
  global $template;
  $template->addCSS("node_modules/@orestbida/iframemanager/dist/iframemanager.css");
}

function add_iframemanager_js(){
  global $template;
  $template->addJS("node_modules/@orestbida/iframemanager/dist/iframemanager.js");
  $template->addJS("plugins/iframemanager/js/iframemanager-init.js");
}

$hooks->add_action('add_css_action','add_iframemanager_css');
$hooks->add_action('add_js_action','add_iframemanager_js');
?>
