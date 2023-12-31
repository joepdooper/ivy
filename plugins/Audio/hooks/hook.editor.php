<?php
defined('_BASE_PATH') or die('Something went wrong');

if($auth->isLoggedIn()){
  if(canEditAsEditor($auth)){

    function audio_insert_update_delete_route(){
      global $router;
      $router->post('/audio/(\w+)/(\d+)(/\w+)?(/\d+)?', function($action, $id, $page_route = null, $page_id = null) {

        $item = new \Ivy\Item();
        $audio = new \Audio\Item();

        $redirect = _BASE_PATH . (isset($page_id) && $action != 'delete' ? htmlentities($page_route) . DIRECTORY_SEPARATOR . htmlentities($page_id) : "");

        switch ($action) {
          case 'insert':
          $audio->insert(['file' => null]);
          $item->insert(['template' => $id, 'parent' => $page_id]);
          \Ivy\Message::add('Audio inserted', $redirect);
          break;
          case 'update':
          $item->where('id', $id)->getRow();
          $audio->where('id', $item->data->table_id)->getRow();
          if (isset($_POST['delete_audio'])) {
            $audio->unlink();
          }
          $audio->data->file = isset($_POST['delete_audio']) ? NULL : (isset($_POST['audio']) ? trim($_POST['audio']) : $audio->data->file);
          if(!empty($_FILES['upload_audio']['name'])){
            $audio->data->file = $audio->upload($_FILES['upload_audio']);
          }
          $item->update(['published' => $_POST['publish_item']]);
          $audio->update(['file' => $audio->data->file]);
          \Ivy\Message::add('Audio updated', $redirect);
          break;
          case 'delete':
          $item->where('id', $id)->getRow();
          $audio->where('id', $item->data->table_id)->getRow();
          if (!empty($audio->data->file)) {
            $audio->unlink();
          }
          $audio->delete();
          $item->delete();
          \Ivy\Message::add('Audio deleted', $redirect);
          break;
        }

      });
    }

    function add_audio_admin_js(){
      global $page;
      $page->addJS("plugins/Audio/js/audio_admin.js");
    }

    $hooks->add_action('start_router_action','audio_insert_update_delete_route');
    $hooks->add_action('add_js_action','add_audio_admin_js');

  }
}
?>
