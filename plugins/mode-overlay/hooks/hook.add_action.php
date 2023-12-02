<?php
defined('_BASE_PATH') or die('Something went wrong');

function add_overlay_object(){
  include_once _PUBLIC_PATH . _PLUGIN_PATH . 'mode-overlay/classes/class.Overlay.php';
}

function add_overlay_css(){
  global $page;
  $page->addCSS("css/overlay.css");
}

$hooks->add_action('add_start_action','add_overlay_object');
$hooks->add_action('add_css_action','add_overlay_css');

?>
