<?php
defined('_BASE_PATH') or die('Something went wrong');

if($auth->isLoggedIn()){
  if(canEditAsEditor($auth)){

    function tag_post_route(){
      global $router, $db, $auth, $page, $button;
      $router->post('/tag/post', function() use($db, $auth, $page, $button) {
        (new \Tag\Item)->post();
      });
    }

    $hooks->add_action('start_router_action','tag_post_route');

  }
}
?>
