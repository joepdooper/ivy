<?php
defined('_BASE_PATH') or die('Something went wrong');

if($auth->isLoggedIn()){
  if(canEditAsEditor($auth)){

    function text_insert_update_delete_route(){
      global $router;
      $router->post('/text/(\w+)/(\d+)(/\w+)?(/\d+)?', function($action, $id, $page_route = null, $page_id = null) {

        $item = new \Ivy\Item();
        $text = new \Text\Item();

        $redirect = _BASE_PATH . (isset($page_id) && $action != 'delete' ? htmlentities($page_route) . DIRECTORY_SEPARATOR . htmlentities($page_id) : "");

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

    function add_text_toolbar(){
      global $page;
      include $page->setTemplateFile(_PLUGIN_PATH . 'Text/template/toolbar.php');
    }

    function add_text_admin_js(){
      global $page;
      $page->addJS("plugins/Text/js/text_admin.js");
    }

    $hooks->add_action('start_router_action','text_insert_update_delete_route');
    $hooks->add_action('end_wrapper_action','add_text_toolbar');
    $hooks->add_action('add_js_action','add_text_admin_js');

  }
}
?>
