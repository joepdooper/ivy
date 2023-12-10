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

$hooks->add_action('add_start_action','add_vimeo_object');
$hooks->add_action('add_js_action','add_vimeo_player');

if($auth->isLoggedIn()){

  function vimeo_insert_update_delete_route(){
    global $router;
    $router->post('/vimeo/(\w+)/(\d+)(/\w+)?(/\d+)?', function($action, $id, $page_route = null, $page_id = null) {

      $item = new \Ivy\Item();
      $vimeo = new Vimeo();

      $redirect = _BASE_PATH . (isset($page_id) ? htmlentities($page_route) . DIRECTORY_SEPARATOR . htmlentities($page_id) : "");

      switch ($action) {
        case 'insert':
        $vimeo->insert(['vimeo_video_id' => '876176995']);
        $item->insert(['template' => $id, 'parent' => $page_id]);
        \Ivy\Message::add('Vimeo inserted', $redirect);
        break;
        case 'update':
        $item->where('id', $id)->getRow();
        $vimeo->where('id', $item->data->table_id)->getRow();
        $item->update(['published' => $_POST['publish_item']]);
        $vimeo->update(['vimeo_video_id' => $_POST['vimeo_video_id']]);
        \Ivy\Message::add('Vimeo updated', $redirect);
        break;
        case 'delete':
        $item->where('id', $id)->getRow();
        $vimeo->where('id', $item->data->table_id)->getRow();
        $item->delete();
        $vimeo->delete();
        \Ivy\Message::add('Vimeo deleted', $redirect);
        break;
      }

    });
  }

  $hooks->add_action('start_router_action','vimeo_insert_update_delete_route');

}

?>
