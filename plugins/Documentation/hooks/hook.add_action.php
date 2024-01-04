<?php
defined('_BASE_PATH') or die('Something went wrong');

function add_documentation_css(){
  global $page;
  $page->addCSS("plugins/Documentation/css/documentation.css");
}

function documentation_show_page(){
  global $router, $db, $auth, $page, $button;
  $router->get('/documentation/(\d+)', function($id) use($db, $auth, $page, $button) {
    $item = (new \Ivy\Item)->where('id',$id)->getRow()->data();
    $page->content = $page->setTemplateFile(_PLUGIN_PATH . $item->plugin_url . '/template/page.php');
    include $page->setTemplateFile('main.php');
  });
}

$hooks->add_action('add_css_action','add_documentation_css');
$hooks->add_action('start_container_action','documentation_show_page');
?>
