<?php
defined('_BASE_PATH') or die('Something went wrong');

// function add_darkmode_css(){
//   print '<link defer href="';
//   print _PLUGIN_PATH . 'mode-dark/template/css/dark-mode.css';
//   print '" rel="stylesheet" type="text/css">';
// }

function add_darkmode_checkbox(){
  global $page;
  include $page->setTemplateFile(_PLUGIN_PATH . 'mode-dark/template/checkbox.php');
}

function add_darkmode_js(){
  print '<script src="';
  print _BASE_PATH . _PLUGIN_PATH . 'mode-dark/js/dark-mode.js';
  print '"></script>';
}

// $hooks->add_action('add_css_action','add_darkmode_css');
$hooks->add_action('start_body_action','add_darkmode_checkbox',11);
$hooks->add_action('start_body_action','add_darkmode_js',12);


?>
