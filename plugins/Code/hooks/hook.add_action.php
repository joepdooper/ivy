<?php
defined('_BASE_PATH') or die('Something went wrong');

function add_code_css(){
  global $template;
  $template->addCSS("plugins/Code/css/code.css");
}

function add_code_js(){
  global $template;
  $template->addJS("plugins/Code/js/rainbow.min.js");
}

$hooks->add_action('add_css_action','add_code_css');
$hooks->add_action('add_js_action','add_code_js');
?>
