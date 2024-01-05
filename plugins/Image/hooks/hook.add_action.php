<?php
defined('_BASE_PATH') or die('Something went wrong');

function add_image_css(){
  global $page;
  $page->addCSS("plugins/Image/css/image.css");
}

$hooks->add_action('add_css_action','add_image_css');
?>
