<?php
defined('_BASE_PATH') or die('Something went wrong');

function style_item_route(){
  global $router, $db, $auth;
  if($auth->isLoggedIn()):
    $router->post('/item/style/', function() use($db, $auth){
      $config = HTMLPurifier_Config::createDefault();
      $purifier = new HTMLPurifier($config);

      $_POST = json_decode(file_get_contents("php://input"),true);

      foreach($_POST['data'] as $key => $value) {
        $db->update(
          'items',
          [
            // set
            'class' => $purifier->purify($value)
          ],
          [
            // where
            'id' => $key
          ]
        );
      };
      echo json_encode('success');
    });
  endif;
}

$hooks->add_action('start_router_action','style_item_route');

?>
