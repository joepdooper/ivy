<?php
defined('_BASE_PATH') or die('Something went wrong');

use Ivy\Item;
use Ivy\Template;

global $router, $db, $auth;

$router->get('/documentation/(\d+)', function($id) use($auth) {
    $item = (new Item)->where('id',$id)->getRow()->data();
    if($item->published || $item->author){
        Template::file(_PLUGIN_PATH . $item->plugin_url . '/template/page.php', $item, 'main');
    }
});

Template::addCSS("plugins/Documentation/css/documentation.css");