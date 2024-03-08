<?php
defined('_BASE_PATH') or die('Something went wrong');

function add_template_root_css(){
    \Ivy\Template::addCSS('css/normalize.css');
    \Ivy\Template::addCSS('css/style_root.css');
}

function add_template_default_css(){
    \Ivy\Template::addCSS('css/simple-grid.css');
    \Ivy\Template::addCSS('css/style.css');
    \Ivy\Template::addCSS('css/swup.css');
    \Ivy\Template::addCSS('css/overlay.css');
}

function add_template_sub_css(){
    \Ivy\Template::addCSS('css/style_sub.css');
}

function add_template_js(){
    \Ivy\Template::addJS("node_modules/axios/dist/axios.min.js");
    \Ivy\Template::addJS("node_modules/petite-vue/dist/petite-vue.umd.js");
    \Ivy\Template::addJS("templates/base/js/template.js");
}

$hooks->add_action('add_css_action','add_template_root_css',1);
$hooks->add_action('add_css_action','add_template_default_css',3);
$hooks->add_action('add_css_action','add_template_sub_css',5);
$hooks->add_action('add_js_action','add_template_js',1);
?>
