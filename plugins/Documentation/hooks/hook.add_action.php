<?php
defined('_BASE_PATH') or die('Something went wrong');

function add_documentation_css(){
  global $template;
  $template->addCSS("plugins/Documentation/css/documentation.css");
}

function documentation_show_page(){
  global $router, $db, $auth, $template, $button;
  $router->get('/documentation/(\d+)', function($id) use($db, $auth, $template, $button) {
    $item = (new \Ivy\Item)->where('id',$id)->getRow()->data();
    if($item->published){
      $template->content = $template->setTemplateFile(_PLUGIN_PATH . $item->plugin_url . '/template/page.php');
    }
    include $template->setTemplateFile('main.php');
  });
}

$hooks->add_action('add_css_action','add_documentation_css');
$hooks->add_action('start_container_action','documentation_show_page');
?>
