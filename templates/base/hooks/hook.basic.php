<?php
defined('_BASE_PATH') or die('Something went wrong');

function add_template_root_css(){
  global $page;
  $page->addCSS('css/normalize.css');
	$page->addCSS('css/style_root.css');
}

function add_template_default_css(){
  global $page;
  $page->addCSS('css/simple-grid.css');
	$page->addCSS('css/style.css');
	$page->addCSS('css/overlay.css');
}

function add_template_sub_css(){
  global $page;
	$page->addCSS('css/style_sub.css');
}

function add_template_js(){
  global $page;
  $page->addJS("node_modules/petite-vue/dist/petite-vue.umd.js");
  $page->addJS("node_modules/axios/dist/axios.min.js");
  $page->addJS("templates/base/js/template.js");
}

$hooks->add_action('add_css_action','add_template_root_css',1);
$hooks->add_action('add_css_action','add_template_default_css',3);
$hooks->add_action('add_css_action','add_template_sub_css',5);
$hooks->add_action('add_js_action','add_template_js',1);
?>
