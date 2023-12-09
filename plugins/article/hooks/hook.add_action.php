<?php
defined('_BASE_PATH') or die('Something went wrong');

function add_article_object(){
  include_once _PUBLIC_PATH . _PLUGIN_PATH . 'article/classes/class.Article.php';
}

function article_insert_update_delete_route(){
  global $router, $db, $auth;
  if($auth->isLoggedIn()){
    $router->post('/article/(\w+)/(\d+)(/\w+)?(/\d+)?', function($action, $id, $page_route = null, $page_id = null) use($db,$auth) {

      $item = new \Ivy\Item();
      $article = new Article();

      $redirect = _BASE_PATH . (isset($page_id) ? htmlentities($page_route) . DIRECTORY_SEPARATOR . htmlentities($page_id) : "");

      switch ($action) {
        case 'insert':
        $article->insert(['title' => 'Title', 'subtitle' => 'Subtitle', 'subject' => $db->selectValue('SELECT `id` FROM `tag` LIMIT 0, 1',[])]);
        $item->insert(['template' => $id, 'parent' => $page_id]);
        \Ivy\Message::add('Article inserted', $redirect);
        break;
        case 'update':
        $item->where('id', $id)->getRow();
        $article->where('id', $item->data->table_id)->getRow();
        $item->update(['published' => $_POST['publish_item'], 'date' => $_POST['datetime']]);
        require_once _PUBLIC_PATH . _PLUGIN_PATH . 'article/posts/update.php';
        $article->update(['title' => $title, 'subtitle' => $subtitle, 'subject' => $subject, 'image' => $image]);
        \Ivy\Message::add('Article updated', $redirect);
        break;
        case 'delete':
        $item->where('id', $id)->getRow();
        $article->where('id', $item->data->table_id)->getRow();
        (new Image)->unlink($article->image);
        $item->delete();
        $article->delete();
        \Ivy\Message::add('Article deleted', $redirect);
        break;
      }

    });
  }
}

function article_show_page(){
  global $router, $db, $auth, $page, $button;
  $router->get('/article/(\d+)', function($id) use($db, $auth, $page, $button) {
    $item = (new \Ivy\Item)->where('id',$id)->getRow()->data();
    $page->content = $page->setTemplateFile(_PLUGIN_PATH . $item->plugin . '/template/' . $item->page_template_file);
    include $page->setTemplateFile('main.php');
  });
}

$hooks->add_action('add_start_action','add_article_object');
$hooks->add_action('start_router_action','article_insert_update_delete_route');
$hooks->add_action('start_container_action','article_show_page');
?>
