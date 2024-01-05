<?php
defined('_BASE_PATH') or die('Something went wrong');

function add_gig_css(){
  global $page;
  $page->addCSS(_PLUGIN_PATH . "Gig/css/gig.css");
}

$hooks->add_action('add_css_action','add_gig_css');
?>
