<?php
// https://github.com/bramus/router

// BEFORE MIDDLEWARE

$router->before('GET', '/.*', function() {
  global $auth, $setting;
  if(!$auth->isLoggedIn() && $setting['private']->bool){
    if(_CURRENT_PAGE != _BASE_PATH . 'admin/login'){
      header('location:' . _BASE_PATH . 'admin/login');
      exit;
    }
  }
});

$router->before('GET|POST', '/admin/([a-z0-9_-]+)', function($id) {
  global $auth;
  if($auth->isLoggedIn()){
    if(!canEditAsAdmin($auth) && !in_array($id,['register','login','logout','reset','profile'])){
      header('location:' . _BASE_PATH);
      exit();
    }
  }
});

$router->before('GET|POST', '/plugin/.*', function() {
  global $auth;
  if($auth->isLoggedIn()){
    if(!canEditAsSuperAdmin($auth)){
      header('location:' . _BASE_PATH);
      exit();
    }
  } else {
    header('location:' . _BASE_PATH . 'admin/login');
  }
});

// ROUTING

// $router->mount('/admin', function() use ($router, $db, $auth, $template, $button) {
//
//     $router->get('/', function() {
//       header('location:' . _BASE_PATH . 'admin/login');
//       exit;
//     });
//
//     $router->get('/(\w+)', function($id) use ($db, $auth, $template, $button) {
//
//       if (!$auth->isLoggedIn() && !in_array($id,['login','reset','register'])) {
//         header('location:' . _BASE_PATH . 'admin/login');
//         exit;
//       }
//
//       $template->route = "admin";
//       $template->id = htmlentities($id);
//       $template->url = DIRECTORY_SEPARATOR . htmlentities("admin") . DIRECTORY_SEPARATOR . htmlentities($id);
//
//     });
//
// });

$router->get('/admin/(\w+)(/[^/]+)?(/[^/]+)?', function($id, $selector = null, $token = null) use($db, $auth, $template, $button) {
  if(in_array($id,['setting','logout','media','plugin','profile','template','user'])){
    $template->route = "admin";
    $template->id = htmlentities($id);
    $template->url = DIRECTORY_SEPARATOR . htmlentities("admin") . DIRECTORY_SEPARATOR . htmlentities($id);
    if (!$auth->isLoggedIn()) {
      header('location:' . _BASE_PATH . 'admin/login');
      exit;
    }
  }
  if($auth->isLoggedIn() && in_array($id,['setting','media','plugin','register','reset','template','user'])){
    if (!canEditAsAdmin($auth)){
      header('location:' . _BASE_PATH . 'admin/profile');
      exit;
    }
  }
  if($id === 'profile' && $selector && $token){
    if ($auth->isLoggedIn()) {
      include _PUBLIC_PATH . 'core/include/login.php';
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
  global $template;
  $template->route = htmlentities($route);
  $template->id = htmlentities($id);
  $template->url = DIRECTORY_SEPARATOR . htmlentities($route) . DIRECTORY_SEPARATOR . htmlentities($id);
});

$router->get('/', function() {
  global $template;
  $template->route = "start";
  $template->url = "";
});

$router->set404(function() {
  header('HTTP/1.1 404 Not Found');
});
?>
