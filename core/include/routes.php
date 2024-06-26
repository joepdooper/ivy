<?php
use Ivy\Setting;
use Ivy\Template;
use Ivy\User;

global $db, $auth, $router;

// BEFORE MIDDLEWARE

$router->before('GET', '/.*', function() {
    global $auth;
    if(!$auth->isLoggedIn() && Setting::$cache['private']->bool){
        if(_CURRENT_PAGE != _BASE_PATH . 'admin/login'){
            header('location:' . _BASE_PATH . 'admin/login');
            exit;
        }
    }
});

$router->before('GET|POST', '/admin/([a-z0-9_-]+)', function($id) {
    global $auth;
    if($auth->isLoggedIn()){
        if(!User::canEditAsAdmin($auth) && !in_array($id,['register','login','logout','reset','profile'])){
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
        if(!User::canEditAsSuperAdmin($auth)){
            header('location:' . _BASE_PATH);
            exit();
        }
    } else {
        header('location:' . _BASE_PATH . 'admin/login');
    }
});

$router->before('GET|POST', '/([a-z0-9_-]+)/([a-z0-9_-]+)', function ($route, $id) {
    Template::$route = htmlentities($route);
    Template::$id = htmlentities($id);
    Template::$url = DIRECTORY_SEPARATOR . Template::$route . DIRECTORY_SEPARATOR . Template::$id;
});

// ROUTING

// -- ADMIN
$router->mount('/admin', function() use ($router, $db, $auth) {

    $router->before('GET','/', function() {
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

    $router->get('/(\w+)(/[^/]+)?(/[^/]+)?', function($id, $selector = null, $token = null) use($db, $auth) {
        switch ($id) {
            case "reset":
            case "login":
                if ($auth->isLoggedIn()) {
                    header('location: ' . _BASE_PATH . 'admin/profile');
                    exit;
                }
                include _PUBLIC_PATH . 'core/include/login.php';
                break;
            case "profile":
                if ($auth->isLoggedIn() && $selector && $token) {
                    include _PUBLIC_PATH . 'core/include/login.php';
                }
                break;
        }
        if (!$auth->isLoggedIn() && !in_array($id,['login','reset','register'])) {
            header('location:' . _BASE_PATH . 'admin/login');
            exit;
        }
        if($auth->isLoggedIn() && in_array($id,['setting','plugin','register','reset','template','user'])){
            if (!User::canEditAsAdmin($auth)){
                header('location:' . _BASE_PATH . 'admin/profile');
                exit;
            }
        }
    });

});

// -- 404
$router->set404(function() {
    header('HTTP/1.1 404 Not Found');
});
