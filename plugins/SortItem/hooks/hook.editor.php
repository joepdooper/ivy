<?php
defined('_BASE_PATH') or die('Something went wrong');
global $auth;

if($auth->isLoggedIn()){
  if(\Ivy\User::canEditAsEditor($auth)){
      global $router;

      $router->post('/item/sort/', function(){

        $_POST = json_decode(file_get_contents("php://input"),true);
        $item = new \Ivy\Item();

        foreach($_POST['data'] as $key => $value) {
          $item->where('id',$value)->update(['sort' => $key]);
        }
        echo json_encode('success');
        exit;
      });

    function add_sort_item_css(): void
    {
      print "<link defer href='" . _BASE_PATH . _PLUGIN_PATH . "SortItem/css/sort.css' rel='stylesheet' type='text/css'>";
    }

    function add_sort_item_js(): void
    {
      print "<script src='" . _BASE_PATH . "node_modules/sortablejs/Sortable.min.js'></script>";
      print "<script src='" . _BASE_PATH . _PLUGIN_PATH . "SortItem/js/SortItem.js'></script>";
    }

    global $hooks;
    $hooks->add_action('add_js_action','add_sort_item_css');
    $hooks->add_action('add_js_action','add_sort_item_js');

  }
}
