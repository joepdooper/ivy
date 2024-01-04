<?php
defined('_BASE_PATH') or die('Something went wrong');

function add_youtube_css(){
  global $page;
  $page->addCSS("plugins/Youtube/css/youtube.css");
}

function add_youtube_js(){
  global $page;
  if (!in_array("IframeManager", $_SESSION['plugins_active'])):
    $page->addJS("plugins/Youtube/js/youtube.js");
  endif;
}

$hooks->add_action('add_css_action','add_youtube_css');
$hooks->add_action('add_js_action','add_youtube_js');

?>
