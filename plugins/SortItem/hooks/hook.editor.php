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
      global $template;
      $template->addCSS("plugins/SortItem/css/sort.css");
    }

    function add_sort_item_js(){
      global $template;
      $template->addJS("node_modules/sortablejs/Sortable.min.js");
      $template->addJS("plugins/SortItem/js/SortItem.js");
    }

    $hooks->add_action('start_router_action','sort_item_route');
    $hooks->add_action('add_js_action','add_sort_item_css');
    $hooks->add_action('add_js_action','add_sort_item_js');

  }
}
?>
