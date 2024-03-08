<?php
defined('_BASE_PATH') or die('Something went wrong');
global $router, $db, $auth;

$router->get('/article/(\d+)', function($id) use($db, $auth) {

    $item = (new \Ivy\Item)->where('id',$id)->getRow()->data();
    if($item->published || $item->author){
        $article = (new \Article\Item)->where('id', $item->table_id)->getRow()->data();
        \Ivy\Setting::$cache['title']->value = $article->title;
        \Ivy\Template::$file = \Ivy\Template::setTemplateFile(_PLUGIN_PATH . $item->plugin_url . '/template/page.php', $item);
    }

});

\Ivy\Template::addCSS("plugins/Article/css/article.css");