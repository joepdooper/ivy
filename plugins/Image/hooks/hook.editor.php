<?php
defined('_BASE_PATH') or die('Something went wrong');

if($auth->isLoggedIn()){
  if(canEditAsEditor($auth)){

    function image_insert_update_delete_route(){
      global $router, $db, $auth;
      if($auth->isLoggedIn()){
        $router->post('/image/(\w+)/(\d+)(/\w+)?(/\d+)?', function($action, $id, $page_route = null, $page_id = null) {

          $item = new \Ivy\Item();
          $image = new \Image\Item();

          $redirect = _BASE_PATH . (isset($page_id) && $action != 'delete' ? htmlentities($page_route) . DIRECTORY_SEPARATOR . htmlentities($page_id) : "");

          switch ($action) {
            case 'insert':
            $image->insert(['file' => null]);
            $item->insert(['template' => $id, 'parent' => $page_id]);
            \Ivy\Message::add('Image inserted', $redirect);
            break;
            case 'update':
            $item->where('id', $id)->getRow();
            $image->where('id', $item->data->table_id)->getRow();
            if (isset($_POST['delete_image'])) {
              $image->unlink();
            }
            $image->data->file = isset($_POST['delete_image']) ? NULL : (isset($_POST['image']) ? trim($_POST['image']) : $image->data->file);
            if(!empty($_FILES['upload_image']['name'])){
              $image->data->file = $image->upload($_FILES['upload_image']);
            }
            $item->update(['published' => $_POST['publish_item']]);
            $image->update(['file' => $image->data->file]);
            \Ivy\Message::add('Image updated', $redirect);
            break;
            case 'delete':
            $item->where('id', $id)->getRow();
            $image->where('id', $item->data->table_id)->getRow();
            if (!empty($image->data->file)) {
              $image->unlink();
            }
            $image->delete();
            $item->delete();
            \Ivy\Message::add('Image deleted', $redirect);
            break;
          }

        });
      }
    }

    function image_post_route(){
      global $router, $db, $auth, $page, $button;
      $router->post('/image/post', function() use($db, $auth, $page, $button) {
        (new \Image\Item)->post();
      });
    }

    function image_sizes_post_route(){
      global $router, $db, $auth, $page, $button;
      $router->post('/image_sizes/post', function() use($db, $auth, $page, $button) {
        (new \Image\Settings)->post();
      });
    }

    function add_image_admin_js(){
      global $page;
      $page->addJS("plugins/Image/js/image_admin.js");
    }

    $hooks->add_action('start_router_action','image_insert_update_delete_route');
    $hooks->add_action('start_router_action','image_post_route');
    $hooks->add_action('start_router_action','image_sizes_post_route');
    $hooks->add_action('add_js_action','add_image_admin_js');

  }
}
?>
