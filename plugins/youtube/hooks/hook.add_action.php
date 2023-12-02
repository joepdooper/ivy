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

function youtube_insert_route(){
  global $router, $db, $auth;
  if($auth->isLoggedIn()):
    $router->post('/youtube/insert/(\d+)(/\w+)?(/\d+)?', function($id, $page_route = null, $page_id = null) use($db, $auth) {
      // -- INSERT
      (new Youtube)->insert(['youtube_video_id' => null]);
      (new \Ivy\Item)->insert($id, $db->getLastInsertId(), 0, $page_id);
      // -- REDIRECT
      $redirect = _BASE_PATH . (isset($page_id) ? htmlentities($page_route) . DIRECTORY_SEPARATOR . htmlentities($page_id) : "");
      \Ivy\Message::add('Youtube inserted', $redirect);
    });
  endif;
}

function youtube_update_route(){
  global $router, $db, $auth;
  if($auth->isLoggedIn()):
    $router->post('/youtube/update/(\d+)(/\w+)?(/\d+)?', function($id, $page_route = null, $page_id = null) use($db, $auth) {
      // -- DEFINE
      $item = new \Ivy\Item($id);
      $youtube = (new Youtube)->where('id', $item->table_id)->get()->data();
      // -- REDIRECT
      $redirect = _BASE_PATH . (isset($page_id) ? htmlentities($page_route) . DIRECTORY_SEPARATOR . htmlentities($page_id) : "");
      if(isset($_POST['delete_item'])){
        // -- DELETE
        $item->delete();
        $youtube->where('id', $item->table_id)->delete();
        \Ivy\Message::add('Youtube deleted', $redirect);
      } else {
        // -- UPDATE
        $item->update();
        $youtube_video_id = isset($_POST['youtube_video_id']) ? $_POST['youtube_video_id'] : NULL;
        if(!$youtube_video_id){
          \Ivy\Message::add('Please enter video id');
        }
        $youtube->where('id', $item->table_id)->update(['youtube_video_id' => $youtube_video_id]);
        \Ivy\Message::add('Youtube updated', $redirect);
      }
    });
  endif;
}

$hooks->add_action('add_start_action','add_youtube_object');
$hooks->add_action('add_css_action','add_youtube_css');
$hooks->add_action('add_js_action','add_youtube_js');
$hooks->add_action('start_router_action','youtube_insert_route');
$hooks->add_action('start_router_action','youtube_update_route');
?>
