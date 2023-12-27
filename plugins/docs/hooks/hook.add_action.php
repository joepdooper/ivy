<?php
defined('_BASE_PATH') or die('Something went wrong');

function add_docs_object(){
  include_once _PUBLIC_PATH . _PLUGIN_PATH . 'docs/classes/class.Docs.php';
}

function add_docs_css(){
  global $page;
  $page->addCSS("plugins/docs/css/docs.css");
}

function docs_show_page(){
  global $router, $db, $auth, $page, $button;
  $router->get('/docs/(\d+)', function($id) use($db, $auth, $page, $button) {
    $item = (new \Ivy\Item)->where('id',$id)->getRow()->data();
    $page->content = $page->setTemplateFile(_PLUGIN_PATH . $item->plugin . '/template/' . $item->page_template_file);
    include $page->setTemplateFile('main.php');
  });
}

$hooks->add_action('add_start_action','add_docs_object');
$hooks->add_action('add_css_action','add_docs_css');
$hooks->add_action('start_container_action','docs_show_page');


if($auth->isLoggedIn()){

  function docs_insert_update_delete_route(){
    global $router, $db, $auth;
    $router->post('/docs/(\w+)/(\d+)(/\w+)?(/\d+)?', function($action, $id, $page_route = null, $page_id = null) use($db, $auth) {

      $item = new \Ivy\Item();
      $docs = new Docs();

      $redirect = _BASE_PATH . (isset($page_id) ? htmlentities($page_route) . DIRECTORY_SEPARATOR . htmlentities($page_id) : "");

      switch ($action) {
        case 'insert':
        $docs->insert(['item_template_id' => $id, 'title' => 'Title', 'subtitle' => 'Subtitle', 'subject' => $db->selectValue('SELECT `id` FROM `tag` LIMIT 0, 1',[])]);
        $docs_id = $db->getLastInsertId();
        $item->insert(['template' => $id, 'parent' => $page_id]);
        $docs->where('id', $docs_id)->update(['item_id' => $db->getLastInsertId()]);
        \Ivy\Message::add('Docs inserted', $redirect);
        break;
        case 'update':
        $item->where('id', $id)->getRow();
        $docs->where('id', $item->data->table_id)->getRow();
        $item->update(['published' => $_POST['publish_item']]);
        require_once _PUBLIC_PATH . _PLUGIN_PATH . 'docs/posts/update.php';
        $docs->update(['title' => $title, 'subtitle' => $subtitle, 'subject' => $subject]);
        \Ivy\Message::add('Docs updated', $redirect);
        break;
        case 'delete':
        $item->where('id', $id)->getRow();
        $docs->where('id', $item->data->table_id)->getRow();
        $item->delete();
        $docs->delete();
        \Ivy\Message::add('Docs deleted', $redirect);
        break;
      }

    });
  }

  $hooks->add_action('start_router_action','docs_insert_update_delete_route');

}
?>
