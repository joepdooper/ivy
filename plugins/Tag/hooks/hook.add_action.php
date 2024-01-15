<?php
defined('_BASE_PATH') or die('Something went wrong');

function add_tag_css(){
  global $template;
  $template->addCSS("plugins/Tag/css/tag.css");
}

$hooks->add_action('add_css_action','add_tag_css');
?>
