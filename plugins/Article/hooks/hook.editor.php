<?php
defined('_BASE_PATH') or die('Something went wrong');

if($auth->isLoggedIn()){
  if(canEditAsEditor($auth)){

    function article_insert_update_delete_route(){
      global $router, $db, $auth;
      $router->post('/article/(\w+)/(\d+)(/\w+)?(/\d+)?', function($action, $id, $template_route = null, $template_id = null) use($db,$auth) {

        $item = new \Ivy\Item();
        $article = new \Article\Item();

        $redirect = _BASE_PATH . (isset($template_id) && $action != 'delete' ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($template_id) : "");

        switch ($action) {
          case 'insert':
          $article->insert(['title' => 'Title', 'subtitle' => 'Subtitle', 'subject' => $db->selectValue('SELECT `id` FROM `tag` LIMIT 0, 1',[])]);
          $item->insert(['template' => $id, 'parent' => $template_id]);
          \Ivy\Message::add('Article inserted', $redirect);
          break;
          case 'update':
          $item->where('id', $id)->getRow();
          $article->where('id', $item->data->table_id)->getRow();
          if(isset($_POST['datetime'])){
            $item->update(['published' => $_POST['publish_item'], 'date' => $_POST['datetime']]);
          } else {
            $item->update(['published' => $_POST['publish_item']]);
          }
          require_once _PUBLIC_PATH . _PLUGIN_PATH . 'Article/posts/update.php';
          $article->update(['title' => $title, 'subtitle' => $subtitle, 'subject' => $subject, 'image' => $image]);
          \Ivy\Message::add('Article updated', $redirect);
          break;
          case 'delete':
          $item->where('id', $id)->getRow();
          $article->where('id', $item->data->table_id)->getRow();
          (new \Image\Item)->unlink($article->image);
          $item->delete();
          $article->delete();
          \Ivy\Message::add('Article deleted', $redirect);
          break;
        }

      });
    }

    $hooks->add_action('start_router_action','article_insert_update_delete_route');

  }
}
?>
