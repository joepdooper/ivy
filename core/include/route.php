<?php
// https://github.com/bramus/router

// BEFORE MIDDLEWARE

$router->before('GET', '/.*', function() {
  global $auth, $option;
  if(!$auth->isLoggedIn() && $option['private']->bool){
    if(_CURRENT_PAGE != _BASE_PATH . 'admin/login'){
      header('location:' . _BASE_PATH . 'admin/login');
      exit;
    }
  }
});

$router->before('GET|POST', '/admin/([a-z0-9_-]+)', function($id) {
  global $auth;
  if($auth->isLoggedIn()):
    if(!canEditAsAdmin($auth) && !in_array($id,['register','login','logout','reset','profile'])):
      header('location:' . _BASE_PATH);
      exit();
    endif;
  endif;
});

$router->before('GET|POST', '/plugin/.*', function() {
  global $auth;
  if($auth->isLoggedIn()):
    if(!canEditAsSuperAdmin($auth)):
      header('location:' . _BASE_PATH);
      exit();
    endif;
  else:
    header('location:' . _BASE_PATH . 'admin/login');
  endif;
});

// ROUTING

$router->get('/admin/(\w+)', function($id) use($db, $auth, $page, $button) {
  if(in_array($id,['info','logout','media','option','plugin','profile','template','user'])){
    $page->route = "admin";
    $page->id = htmlentities($id);
    $page->url = DIRECTORY_SEPARATOR . htmlentities("admin") . DIRECTORY_SEPARATOR . htmlentities($id);
    if (!$auth->isLoggedIn()) {
      header('location:' . _BASE_PATH . 'admin/login');
      exit;
    }
  }
  if($auth->isLoggedIn() && in_array($id,['info','media','option','plugin','register','reset','template','user'])){
    if (!canEditAsAdmin($auth)){
      header('location:' . _BASE_PATH . 'admin/profile');
      exit;
    }
  }
  if($id === 'login'){
    if ($auth->isLoggedIn()) {
      header('location: ' . _BASE_PATH);
      exit;
    }
    include _PUBLIC_PATH . 'core/include/login.php';
  }
  if($id === 'reset'){
    if ($auth->isLoggedIn()) {
      header('location: ' . _BASE_PATH);
      exit;
    }
    include _PUBLIC_PATH . 'core/include/reset.php';
  }
});

$router->post('/post/register', '\Ivy\User@register');

$router->post('/post/login', '\Ivy\User@login');

$router->post('/post/logout', '\Ivy\User@logout');

$router->post('/post/reset', '\Ivy\User@reset');

$router->post('/post/(\w+)', function($id) use($db, $auth) {
  try {
    if($auth->isLoggedIn()):
      $class = '\Ivy\\' . ucfirst($id);
      (new $class)->post();
    endif;
  } catch(Exception $e) {
    \Ivy\Message::add($e->getMessage(),_BASE_PATH);
  }
});

$router->get('/([a-z0-9_-]+)/(\w+)', function($route,$id) {
  global $page;
  $page->route = htmlentities($route);
  $page->id = htmlentities($id);
  $page->url = DIRECTORY_SEPARATOR . htmlentities($route) . DIRECTORY_SEPARATOR . htmlentities($id);
});

$router->get('/', function() {
  global $page;
  $page->route = "start";
  $page->url = "";
});

$router->set404(function() {
  header('HTTP/1.1 404 Not Found');
});
?>
