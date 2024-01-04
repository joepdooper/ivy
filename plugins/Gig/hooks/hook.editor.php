<?php
defined('_BASE_PATH') or die('Something went wrong');

if($auth->isLoggedIn()){
  if(canEditAsEditor($auth)){

    function gig_insert_update_delete_route(){
      global $router, $db, $auth;
      $router->post('/gig/(\w+)/(\d+)(/\w+)?(/\d+)?', function($action, $id, $page_route = null, $page_id = null) use($db, $auth) {

        $item = new \Ivy\Item();
        $gig = new \Gig\Item();

        $redirect = _BASE_PATH . (isset($page_id) && $action != 'delete' ? htmlentities($page_route) . DIRECTORY_SEPARATOR . htmlentities($page_id) : "");

        switch ($action) {
          case 'insert':
          $gig->insert(['datetime' => date("Y-m-d H:i:s"), 'venue' => 'Venue', 'address' => 'Address', 'subject' => $db->selectValue('SELECT `id` FROM `tag` LIMIT 0, 1',[])]);
          $item->insert(['template' => $id, 'parent' => $page_id]);
          \Ivy\Message::add('Gig inserted', $redirect);
          break;
          case 'update':
          $item->where('id', $id)->getRow();
          $gig->where('id', $item->data->table_id)->getRow();
          $item->update(['published' => $_POST['publish_item']]);
          require_once _PUBLIC_PATH . _PLUGIN_PATH . 'gig/posts/update.php';
          $gig->update(['datetime' => $date . ' ' . $time, 'venue' => $venue, 'address' => $address, 'subject' => $subject]);
          \Ivy\Message::add('gig updated', $redirect);
          break;
          case 'delete':
          $item->where('id', $id)->getRow();
          $gig->where('id', $item->data->table_id)->getRow();
          $item->delete();
          $gig->delete();
          \Ivy\Message::add('Gig deleted', $redirect);
          break;
        }

      });
    }

    $hooks->add_action('start_router_action','gig_insert_update_delete_route');
  }
}
?>
