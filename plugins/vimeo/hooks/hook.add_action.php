<?php
defined('_BASE_PATH') or die('Something went wrong');

function add_vimeo_object(){
  include_once _PUBLIC_PATH . _PLUGIN_PATH . 'vimeo/classes/class.Vimeo.php';
}

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
    print "<script " . $scriptattribute . " src='" . _BASE_PATH . "plugins/vimeo/js/vimeo.js'></script>";
  endif;
}

function vimeo_insert_route(){
  global $router, $db, $auth;
  if($auth->isLoggedIn()):
    $router->post('/vimeo/insert/(\d+)(/\w+)?(/\d+)?', function($id, $page_route = null, $page_id = null) use($db, $auth) {
      // -- INSERT
      (new Vimeo)->insert(['vimeo_video_id' => null]);
      (new \Ivy\Item)->insert($id, $db->getLastInsertId(), 0, $page_id);
      // -- REDIRECT
      $redirect = _BASE_PATH . (isset($page_id) ? htmlentities($page_route) . DIRECTORY_SEPARATOR . htmlentities($page_id) : "");
      \Ivy\Message::add('Vimeo inserted', $redirect);
    });
  endif;
}

function vimeo_update_route(){
  global $router, $db, $auth;
  if($auth->isLoggedIn()):
    $router->post('/vimeo/update/(\d+)(/\w+)?(/\d+)?', function($id, $page_route = null, $page_id = null) use($db, $auth) {
      // -- DEFINE
      $item = new \Ivy\Item($id);
      $vimeo = (new Vimeo)->where('id', $item->table_id)->get()->data();
      // -- REDIRECT
      $redirect = _BASE_PATH . (isset($page_id) ? htmlentities($page_route) . DIRECTORY_SEPARATOR . htmlentities($page_id) : "");
      if(isset($_POST['delete_item'])){
        // -- DELETE
        $item->delete();
        $vimeo->where('id', $item->table_id)->delete();
        \Ivy\Message::add('Vimeo deleted', $redirect);
      } else {
        // -- UPDATE
        $item->update();
        $vimeo_video_id = isset($_POST['vimeo_video_id']) ? $_POST['vimeo_video_id'] : NULL;
        if(!$vimeo_video_id){
          \Ivy\Message::add('Please enter video id');
        }
        $vimeo->where('id', $item->table_id)->update(['vimeo_video_id' => $vimeo_video_id]);
        \Ivy\Message::add('Vimeo updated', $redirect);
      }
    });
  endif;
}

$hooks->add_action('add_start_action','add_vimeo_object');
$hooks->add_action('add_js_action','add_vimeo_player');
$hooks->add_action('start_router_action','vimeo_insert_route');
$hooks->add_action('start_router_action','vimeo_update_route');
?>
