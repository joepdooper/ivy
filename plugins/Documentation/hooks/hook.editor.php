<?php
defined('_BASE_PATH') or die('Something went wrong');

if($auth->isLoggedIn()){
  if(canEditAsEditor($auth)){

    function documentation_insert_update_delete_route(){
      global $router, $db, $auth;
      $router->post('/documentation/(\w+)/(\d+)(/\w+)?(/\d+)?', function($action, $id, $template_route = null, $template_id = null) use($db, $auth) {

        $item = new \Ivy\Item();
        $documentation = new \Documentation\Item();

        $redirect = _BASE_PATH . (isset($template_id) && $action != 'delete' ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($template_id) : "");

        switch ($action) {
          case 'insert':
          $documentation->insert(['item_template_id' => $id, 'title' => 'Title', 'subtitle' => 'Subtitle', 'subject' => $db->selectValue('SELECT `id` FROM `tag` LIMIT 0, 1',[])]);
          $documentation_id = $db->getLastInsertId();
          $item->insert(['template' => $id, 'parent' => $template_id]);
          $documentation->where('id', $documentation_id)->update(['item_id' => $db->getLastInsertId()]);
          \Ivy\Message::add('Documentation inserted', $redirect);
          break;
          case 'update':
          $item->where('id', $id)->getRow();
          $documentation->where('id', $item->data->table_id)->getRow();
          $item->update(['published' => $_POST['publish_item']]);
          require_once _PUBLIC_PATH . _PLUGIN_PATH . 'Documentation/posts/update.php';
          $documentation->update(['title' => $title, 'subtitle' => $subtitle, 'subject' => $subject]);
          \Ivy\Message::add('Documentation updated', $redirect);
          break;
          case 'delete':
          $item->where('id', $id)->getRow();
          $documentation->where('id', $item->data->table_id)->getRow();
          $item->delete();
          $documentation->delete();
          \Ivy\Message::add('Documentation deleted', $redirect);
          break;
        }

      });
    }

    $hooks->add_action('start_router_action','documentation_insert_update_delete_route');

  }
}
?>
