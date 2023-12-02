<?php
defined('_BASE_PATH') or die('Something went wrong');

function add_tag_object(){
  include_once _PUBLIC_PATH . _PLUGIN_PATH . 'tag/classes/class.Tag.php';
}

function tag_post_route(){
  global $router, $db, $auth, $page, $button;
  $router->post('/tag/post', function() use($db, $auth, $page, $button) {
    (new Tag)->post();
  });
}

$hooks->add_action('add_start_action','add_tag_object');
$hooks->add_action('start_router_action','tag_post_route');
?>
