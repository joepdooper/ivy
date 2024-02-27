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
  } else {
    if(!in_array($id,['register','login','reset'])){
      header('location:' . _BASE_PATH . 'admin/login');
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

$router->mount('/admin', function() use ($router, $db, $auth, $template, $button) {

  $router->get('/', function() {
    header('location:' . _BASE_PATH . 'admin/login');
    exit;
  });

  $router->post('/user/register','\Ivy\User@register');

  $router->post('/user/login','\Ivy\User@login');

  $router->post('/user/logout','\Ivy\User@logout');

  $router->post('/user/reset','\Ivy\User@reset');

  $router->post('/user/post','\Ivy\User@post');

  $router->post('/plugin/post','\Ivy\Plugin@post');

  $router->post('/profile/post','\Ivy\Profile@post');

  $router->post('/setting/post','\Ivy\Setting@post');

  $router->post('/template/post','\Ivy\Template@post');

  $router->get('/login(/[^/]+)?(/[^/]+)?', function($selector = null, $token = null) use ($auth, $template) {
    if ($auth->isLoggedIn()) {
      header('location: ' . _BASE_PATH . 'admin/profile');
      exit;
    }
    include _PUBLIC_PATH . 'core/include/login.php';
  });

  $router->get('/reset(/[^/]+)?(/[^/]+)?', function($selector = null, $token = null) use ($auth, $template) {
    if ($auth->isLoggedIn()) {
      header('location: ' . _BASE_PATH  . 'admin/profile');
      exit;
    }
    include _PUBLIC_PATH . 'core/include/login.php';
  });

  $router->get('/profile(/[^/]+)?(/[^/]+)?', function($selector = null, $token = null) use ($auth, $template) {
    if ($auth->isLoggedIn() && $selector && $token) {
      include _PUBLIC_PATH . 'core/include/login.php';
    }
  });

  $router->get('/(\w+)', function($id) use ($db, $auth, $template, $button) {
    if (!$auth->isLoggedIn() && !in_array($id,['login','reset','register'])) {
      header('location:' . _BASE_PATH . 'admin/login');
      exit;
    }
    if($auth->isLoggedIn() && in_array($id,['setting','plugin','register','reset','template','user'])){
      if (!canEditAsAdmin($auth)){
        header('location:' . _BASE_PATH . 'admin/profile');
        exit;
      }
    }
  });

});


$router->get('/([a-z0-9_-]+)/([a-z0-9_-]+)', function($route,$id) use($template) {
  $template->route = htmlentities($route);
  $template->id = htmlentities($id);
  $template->url = DIRECTORY_SEPARATOR . $template->route . DIRECTORY_SEPARATOR . $template->id;
});

$router->get('/', function() {

});

$router->set404(function() {
  header('HTTP/1.1 404 Not Found');
});
?>
