<?php
defined('_BASE_PATH') or die('Something went wrong');
global $auth;

if($auth->isLoggedIn()){
  if(\Ivy\User::canEditAsEditor($auth)){
    global $router, $db;
    $router->post('/tag/post', function() use($db, $auth) {
        (new \Tag\Item)->post();
    });
  }
}
