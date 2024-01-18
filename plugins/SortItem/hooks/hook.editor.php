<?php
defined('_BASE_PATH') or die('Something went wrong');

if($auth->isLoggedIn()){
  if(canEditAsEditor($auth)){

    function sort_item_route(){
      global $router;
      $router->post('/item/sort/', function(){

        $_POST = json_decode(file_get_contents("php://input"),true);
        $item = new \Ivy\Item();

        foreach($_POST['data'] as $key => $value) {
          $item->where('id',$value)->update(['sort' => $key]);
        };
        echo json_encode('success');
        exit;
      });
    }

    function add_sort_item_css(){
      print "<link defer href='" . _BASE_PATH . _PLUGIN_PATH . "SortItem/css/sort.css' rel='stylesheet' type='text/css'>";
    }

    function add_sort_item_js(){
      print "<script src='" . _BASE_PATH . "node_modules/sortablejs/Sortable.min.js'></script>";
      print "<script src='" . _BASE_PATH . _PLUGIN_PATH . "SortItem/js/SortItem.js'></script>";
    }

    $hooks->add_action('start_router_action','sort_item_route');
    $hooks->add_action('add_js_action','add_sort_item_css');
    $hooks->add_action('add_js_action','add_sort_item_js');

  }
}
?>
