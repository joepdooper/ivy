<?php
defined('_BASE_PATH') or die('Something went wrong');

function add_gig_object(){
  include_once _PUBLIC_PATH . _PLUGIN_PATH . 'gig/classes/class.Gig.php';
}

function gig_insert_route(){
  global $router, $db, $auth;
  if($auth->isLoggedIn()):
    $router->post('/gig/insert/(\d+)(/\w+)?(/\d+)?', function($id, $page_route = null, $page_id = null) use($db, $auth) {
      $default_array = [
        // set
        'datetime' => date("Y-m-d H:i:s"),
        'venue' => "Venue",
        'address' => "Address",
        'subject' => $db->selectValue('SELECT `id` FROM `tag` LIMIT 0, 1',[])
      ];
      (new Gig)->insert($default_array);
      (new \Ivy\Item)->insert($id, $db->getLastInsertId(), 0, $page_id);
      $redirect = _BASE_PATH . (isset($page_id) ? htmlentities($page_route) . DIRECTORY_SEPARATOR . htmlentities($page_id) : "");
      \Ivy\Message::add('Gig inserted', $redirect);
    });
  endif;
}

function gig_update_route(){
  global $router, $db, $auth;
  if($auth->isLoggedIn()):
    $router->post('/gig/update/(\d+)(/\w+)?(/\d+)?', function($id, $page_route = null, $page_id = null) use($db, $auth) {
      // -- DEFINE
      $item = new \Ivy\Item($id);
      $gig = (new Gig)->where('id', $item->table_id)->get()->data();
      // -- REDIRECT
      $redirect = _BASE_PATH . (isset($page_id) ? htmlentities($page_route) . DIRECTORY_SEPARATOR . htmlentities($page_id) : "");
      if(isset($_POST['delete_item'])){
        // -- DELETE
        $item->delete();
        $gig->where('id', $item->table_id)->delete();
        \Ivy\Message::add('Gig deleted', $redirect);
      } else {
        // -- UPDATE
        $item->update();
        require_once _PUBLIC_PATH . _PLUGIN_PATH . 'gig/posts/update.php';
        $gig->where('id', $item->table_id)->update(['datetime' => $date . ' ' . $time, 'venue' => $venue, 'address' => $address, 'subject' => $subject]);
        \Ivy\Message::add('Gig updated', $redirect);
      }
    });
  endif;
}

$hooks->add_action('add_start_action','add_gig_object');
$hooks->add_action('start_router_action','gig_insert_route');
$hooks->add_action('start_router_action','gig_update_route');
?>
