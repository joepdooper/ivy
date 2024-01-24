<?php
defined('_BASE_PATH') or die('Something went wrong');

function add_cookie_consent_css(){
  global $template;
  $template->addCSS('node_modules/vanilla-cookieconsent/dist/cookieconsent.css');
}

function add_cookie_consent_js(){
  global $template;
  $template->addESM('plugins/VanillaCookieConsent/js/cookieconsent-config.js');
}

$hooks->add_action('add_css_action','add_cookie_consent_css');
$hooks->add_action('add_js_action','add_cookie_consent_js');
?>
