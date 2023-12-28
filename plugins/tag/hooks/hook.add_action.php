<?php
defined('_BASE_PATH') or die('Something went wrong');

function tag_post_route(){
  global $router, $db, $auth, $page, $button;
  $router->post('/tag/post', function() use($db, $auth, $page, $button) {
    (new tag\Item)->post();
  });
}

$hooks->add_action('start_router_action','tag_post_route');
?>
