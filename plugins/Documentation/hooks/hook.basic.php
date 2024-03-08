<?php
defined('_BASE_PATH') or die('Something went wrong');
global $router, $auth;

$router->get('/documentation/(\d+)', function($id) use($auth) {
    $item = (new \Ivy\Item)->where('id',$id)->getRow()->data();
    if($item->published || $item->author){
        \Ivy\Template::$file = \Ivy\Template::setTemplateFile(_PLUGIN_PATH . $item->plugin_url . '/template/page.php', $item);
    }
});

\Ivy\Template::addCSS("plugins/Documentation/css/documentation.css");