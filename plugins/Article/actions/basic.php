<?php
defined('_BASE_PATH') or die('Something went wrong');

use Ivy\Item;
use Ivy\Setting;
use Ivy\Template;

global $router, $db, $auth;

$router->before('GET', '/article/(\d+)', function($id) use($db, $auth) {
    $item = (new Item)->where('id',$id)->getRow()->data();
    if($item->published || $item->author){
        $item->data = (new \Article\Item)->where('id', $item->table_id)->getRow()->data();
        $item->tags = (new \Tag\ItemTag)->getItemTags($item->id);
        Setting::$cache['title']->value = $item->data->title;
        Template::file(_PLUGIN_PATH . $item->plugin_url . '/template/page.php', $item, 'main');
    }
});

Template::addCSS("plugins/Article/css/article.css");