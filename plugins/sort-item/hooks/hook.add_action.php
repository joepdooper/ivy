<?php
defined('_BASE_PATH') or die('Something went wrong');

function sort_item_route(){
  global $router, $db, $auth;
  if($auth->isLoggedIn()):
    $router->post('/item/sort/', function() use($db, $auth){
      $config = HTMLPurifier_Config::createDefault();
      $purifier = new HTMLPurifier($config);

      $_POST = json_decode(file_get_contents("php://input"),true);

      foreach($_POST['data'] as $key => $value) {
        $db->update(
          'items',
          [
            // set
            'sort' => $purifier->purify($key)
          ],
          [
            // where
            'id' => $value
          ]
        );
      };
      echo json_encode('success');
    });
  endif;
}

$hooks->add_action('start_router_action','sort_item_route');

?>
