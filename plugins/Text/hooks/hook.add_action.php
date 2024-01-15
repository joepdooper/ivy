<?php
defined('_BASE_PATH') or die('Something went wrong');

function add_text_css(){
  global $template;
  $template->addCSS(_PLUGIN_PATH . "Text/css/text.css");
}

function add_text_js(){
  global $template;
  $template->addJS("node_modules/linkifyjs/dist/linkify.min.js");
  $template->addJS("node_modules/linkify-html/dist/linkify-html.min.js");
  $template->addJS("plugins/Text/js/text.js");
}

$hooks->add_action('add_css_action','add_text_css');
$hooks->add_action('add_js_action','add_text_js');
?>
