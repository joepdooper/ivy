<?php
defined('_BASE_PATH') or die('Something went wrong');

function add_vimeo_player(){
  if (!in_array("IframeManager", $_SESSION['plugins_active'])):
    if(isset($_COOKIE['cc_cookie'])):
      $cc_cookie = json_decode($_COOKIE['cc_cookie']);
      $cc_cookie->necessary = in_array("necessary", $cc_cookie->categories) ? true : false;
      $cc_cookie->analytics = in_array("analytics", $cc_cookie->categories) ? true : false;
      $cc_cookie->targeting = in_array("targeting", $cc_cookie->categories) ? true : false;
    endif;
    $scriptattribute = (isset($cc_cookie) && $cc_cookie->analytics) ?: "type='text/plain' data-cookiecategory='analytics'";
    print "<script " . $scriptattribute . " src='https://unpkg.com/@vimeo/player'></script>";
    print "<script " . $scriptattribute . " src='" . _BASE_PATH . "plugins/Vimeo/js/vimeo.js'></script>";
  endif;
}

$hooks->add_action('add_js_action','add_vimeo_player');
?>
