<?php
defined('_BASE_PATH') or die('Something went wrong');

function add_code_css(){
  global $page;
  $page->addCSS("plugins/code/css/code.css");
}

function add_code_js(){
  global $page;
  $page->addJS("plugins/code/js/rainbow.min.js");
}

$hooks->add_action('add_css_action','add_code_css');
$hooks->add_action('add_js_action','add_code_js');

// -- admin
if($auth->isLoggedIn()){

  function code_insert_update_delete_route(){
    global $router;
    $router->post('/code/(\w+)/(\d+)(/\w+)?(/\d+)?', function($action, $id, $page_route = null, $page_id = null) {

      $item = new \Ivy\Item();
      $code = new code\Item();

      $redirect = _BASE_PATH . (isset($page_id) ? htmlentities($page_route) . DIRECTORY_SEPARATOR . htmlentities($page_id) : "");

      switch ($action) {
        case 'insert':
        $code->insert(['code' => 'Insert code…', 'language' => 'php']);
        $item->insert(['template' => $id, 'parent' => $page_id]);
        \Ivy\Message::add('Code inserted', $redirect);
        break;
        case 'update':
        $item->where('id', $id)->getRow();
        $code->where('id', $item->data->table_id)->getRow();
        $item->update(['published' => $_POST['publish_item']]);
        $code->update(['code' => $_POST['code'], 'language' => $_POST['language']]);
        \Ivy\Message::add('Code updated', $redirect);
        break;
        case 'delete':
        $item->where('id', $id)->getRow();
        $code->where('id', $item->data->table_id)->getRow();
        $item->delete();
        $code->delete();
        \Ivy\Message::add('Code deleted', $redirect);
        break;
      }

    });
  }

  $hooks->add_action('start_router_action','code_insert_update_delete_route');

}
?>
