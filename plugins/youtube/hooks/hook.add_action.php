<?php
defined('_BASE_PATH') or die('Something went wrong');

function add_youtube_object(){
  include_once _PUBLIC_PATH . _PLUGIN_PATH . 'youtube/classes/class.Youtube.php';
}

function add_youtube_css(){
  global $page;
  $page->addCSS("plugins/youtube/css/youtube.css");
}

function add_youtube_js(){
  global $page;
  if (!in_array("IframeManager", $_SESSION['plugins_active'])):
    $page->addJS("plugins/youtube/js/youtube.js");
  endif;
}

$hooks->add_action('add_start_action','add_youtube_object');
$hooks->add_action('add_css_action','add_youtube_css');
$hooks->add_action('add_js_action','add_youtube_js');


if($auth->isLoggedIn()){

  function youtube_insert_update_delete_route(){
    global $router, $auth;
    if($auth->isLoggedIn()){
      $router->post('/youtube/(\w+)/(\d+)(/\w+)?(/\d+)?', function($action, $id, $page_route = null, $page_id = null) {

        $item = new \Ivy\Item();
        $youtube = new Youtube();

        $redirect = _BASE_PATH . (isset($page_id) ? htmlentities($page_route) . DIRECTORY_SEPARATOR . htmlentities($page_id) : "");

        switch ($action) {
          case 'insert':
          $youtube->insert(['youtube_video_id' => 'aKydtOXW8mI']);
          $item->insert(['template' => $id, 'parent' => $page_id]);
          \Ivy\Message::add('Youtube inserted', $redirect);
          break;
          case 'update':
          $item->where('id', $id)->getRow();
          $youtube->where('id', $item->data->table_id)->getRow();
          $item->update(['published' => $_POST['publish_item']]);
          $youtube->update(['youtube_video_id' => $_POST['youtube_video_id']]);
          \Ivy\Message::add('Youtube updated', $redirect);
          break;
          case 'delete':
          $item->where('id', $id)->getRow();
          $youtube->where('id', $item->data->table_id)->getRow();
          $item->delete();
          $youtube->delete();
          \Ivy\Message::add('Youtube deleted', $redirect);
          break;
        }

      });
    }
  }

  $hooks->add_action('start_router_action','youtube_insert_update_delete_route');

}
?>
