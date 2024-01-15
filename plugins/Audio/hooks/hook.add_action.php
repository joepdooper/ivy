<?php
defined('_BASE_PATH') or die('Something went wrong');

function add_audio_css(){
  global $template;
  $template->addCSS("plugins/Audio/css/audio.css");
}

$hooks->add_action('add_css_action','add_audio_css');
?>
