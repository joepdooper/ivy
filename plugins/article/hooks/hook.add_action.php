<?php
defined('_BASE_PATH') or die('Something went wrong');

function add_article_css(){
  global $page;
  $page->addCSS("plugins/Article/css/article.css");
}

function article_show_page(){
  global $router, $db, $auth, $page, $button;
  $router->get('/article/(\d+)', function($id) use($db, $auth, $page, $button) {
    $item = (new \Ivy\Item)->where('id',$id)->getRow()->data();
    $page->content = $page->setTemplateFile(_PLUGIN_PATH . $item->plugin_url . '/template/page.php');
    include $page->setTemplateFile('main.php');
  });
}

$hooks->add_action('add_css_action','add_article_css');
$hooks->add_action('start_container_action','article_show_page');
?>
