<?php
defined('_BASE_PATH') or die('Something went wrong');

function add_template_root_css(){
  global $template;
  $template->addCSS('css/normalize.css');
	$template->addCSS('css/style_root.css');
}

function add_template_default_css(){
  global $template;
  $template->addCSS('css/simple-grid.css');
	$template->addCSS('css/style.css');
	$template->addCSS('css/overlay.css');
}

function add_template_sub_css(){
  global $template;
	$template->addCSS('css/style_sub.css');
}

function add_template_js(){
  global $template;
  $template->addJS("node_modules/petite-vue/dist/petite-vue.umd.js");
  $template->addJS("node_modules/axios/dist/axios.min.js");
  $template->addJS("templates/base/js/template.js");
}

$hooks->add_action('add_css_action','add_template_root_css',1);
$hooks->add_action('add_css_action','add_template_default_css',3);
$hooks->add_action('add_css_action','add_template_sub_css',5);
$hooks->add_action('add_js_action','add_template_js',1);
?>
