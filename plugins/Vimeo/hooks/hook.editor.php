<?php
defined('_BASE_PATH') or die('Something went wrong');
global $auth;

if($auth->isLoggedIn()){
  if(\Ivy\User::canEditAsEditor($auth)){
    global $router;

    $router->post('/vimeo/(\w+)/(\d+)(/\w+)?(/\d+)?', function($action, $id, $template_route = null, $template_id = null) {

      $item = new \Ivy\Item();
      $vimeo = new \Vimeo\Item();

      $redirect = _BASE_PATH . (isset($template_id) && $action != 'delete' ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($template_id) : "");

      switch ($action) {
        case 'insert':
          $vimeo->insert(['vimeo_video_id' => '876176995']);
          $item->insert(['template' => $id, 'parent' => $template_id]);
          \Ivy\Message::add('Vimeo inserted', $redirect);
          break;
        case 'update':
          $item->where('id', $id)->getRow();
          $vimeo->where('id', $item->data->table_id)->getRow();
          $item->update(['published' => $_POST['publish_item']]);
          $vimeo->update(['vimeo_video_id' => $_POST['vimeo_video_id']]);
          \Ivy\Message::add('Vimeo updated', $redirect);
          break;
        case 'delete':
          $item->where('id', $id)->getRow();
          $vimeo->where('id', $item->data->table_id)->getRow();
          $item->delete();
          $vimeo->delete();
          \Ivy\Message::add('Vimeo deleted', $redirect);
          break;
      }

    });

  }
}
