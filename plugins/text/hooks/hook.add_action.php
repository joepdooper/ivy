<?php
defined('_BASE_PATH') or die('Something went wrong');

function add_text_object(){
  include_once _PUBLIC_PATH . _PLUGIN_PATH . 'text/classes/class.Text.php';
}

function text_insert_update_delete_route(){
  global $router, $auth;
  if($auth->isLoggedIn()){
    $router->post('/text/(\w+)/(\d+)(/\w+)?(/\d+)?', function($action, $id, $page_route = null, $page_id = null) {

      $item = new \Ivy\Item();
      $text = new Text();

      $redirect = _BASE_PATH . (isset($page_id) ? htmlentities($page_route) . DIRECTORY_SEPARATOR . htmlentities($page_id) : "");

      switch ($action) {
        case 'insert':
        $text->insert(['text' => 'Write…']);
        $item->insert(['template' => $id, 'parent' => $page_id]);
        \Ivy\Message::add('Text inserted', $redirect);
        break;
        case 'update':
        $item->where('id', $id)->getRow();
        $text->where('id', $item->data->table_id)->getRow();
        $item->update(['published' => $_POST['publish_item']]);
        $text->update(['text' => $_POST['text']]);
        \Ivy\Message::add('Text updated', $redirect);
        break;
        case 'delete':
        $item->where('id', $id)->getRow();
        $text->where('id', $item->data->table_id)->getRow();
        $item->delete();
        $text->delete();
        \Ivy\Message::add('Text deleted', $redirect);
        break;
      }

    });
  }
}

function add_text_toolbar(){
  global $button;
  $button->toolbar();
}


$hooks->add_action('add_start_action','add_text_object');
$hooks->add_action('start_router_action','text_insert_update_delete_route');
$hooks->add_action('start_container_action','add_text_toolbar');

?>
