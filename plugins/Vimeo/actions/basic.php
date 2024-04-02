<?php
defined('_BASE_PATH') or die('Something went wrong');

function add_vimeo_player(): void
{
  if(!in_array("IframeManager", $_SESSION['plugin_actives'])):
    if(isset($_COOKIE['cc_cookie'])):
      $cc_cookie = json_decode($_COOKIE['cc_cookie']);
      $cc_cookie->necessary = in_array("necessary", $cc_cookie->categories);
      $cc_cookie->analytics = in_array("analytics", $cc_cookie->categories);
      $cc_cookie->targeting = in_array("targeting", $cc_cookie->categories);
    endif;
    $scriptattribute = (isset($cc_cookie) && $cc_cookie->analytics) ?: "type='text/plain' data-cookiecategory='analytics'";
    print "<script " . $scriptattribute . " src='https://unpkg.com/@vimeo/player'></script>";
    print "<script " . $scriptattribute . " src='" . _BASE_PATH . "plugins/Vimeo/js/vimeo.js'></script>";
  endif;
}

global $hooks;
$hooks->add_action('add_js_action','add_vimeo_player');
