<?php
defined('_BASE_PATH') or die('Something went wrong');

if($auth->isLoggedIn()){
  if(canEditAsEditor($auth)){

    function code_insert_update_delete_route(){
      global $router;
      $router->post('/code/(\w+)/(\d+)(/\w+)?(/\d+)?', function($action, $id, $template_route = null, $template_id = null) {

        $item = new \Ivy\Item();
        $code = new \Code\Item();

        $redirect = _BASE_PATH . (isset($template_id) && $action != 'delete' ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($template_id) : "");

        switch ($action) {
          case 'insert':
          $code->insert(['code' => 'Insert code…', 'language' => 'php']);
          $item->insert(['template' => $id, 'parent' => $template_id]);
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
}
?>
