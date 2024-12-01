<?php

use Ivy\Plugin;
use Ivy\Profile;
use Ivy\Request;
use Ivy\Setting;
use Ivy\Template;
use Ivy\User;

global $router;

// BEFORE MIDDLEWARE

$router->before('GET', '/.*', function () {
    if (!User::isLoggedIn() && Setting::$stash['private']->bool) {
        if (_CURRENT_PAGE != _BASE_PATH . 'admin/login') {
            header('location:' . _BASE_PATH . 'admin/login');
            exit;
        }
    }
});

$router->before('GET|POST', '/admin/([a-z0-9_-]+)', function ($id) {
    if (User::isLoggedIn()) {
        if (!User::canEditAsAdmin() && !in_array($id, ['register', 'login', 'logout', 'reset', 'profile'])) {
            header('location:' . _BASE_PATH);
            exit();
        }
    } else {
        if (!in_array($id, ['register', 'login', 'reset'])) {
            header('location:' . _BASE_PATH . 'admin/login');
            exit();
        }
    }
});

$router->before('GET|POST', '/plugin/.*', function () {
    if (User::isLoggedIn()) {
        if (!User::canEditAsSuperAdmin()) {
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
$router->mount('/admin', function () use ($router) {

    $router->before('GET', '/', function () {
        header('location:' . _BASE_PATH . 'admin/login');
        exit;
    });

    $router->post('/user/register', '\Ivy\User@register');

    $router->post('/user/login', '\Ivy\User@login');

    $router->post('/user/logout', '\Ivy\User@logout');

    $router->post('/user/reset', '\Ivy\User@reset');

    $router->post('/user/post', '\Ivy\UserController@post');

    $router->post('/plugin/post', '\Ivy\PluginController@post');

    $router->post('/profile/post', '\Ivy\Profile@post');

    $router->post('/setting/post', '\Ivy\SettingController@post');

    $router->post('/template/post', '\Ivy\Template@post');

    $router->get('/(\w+)(/[^/]+)?(/[^/]+)?', function ($id, $selector = null, $token = null) {
        switch ($id) {
            case "reset":
            case "login":
                if (User::isLoggedIn()) {
                    header('location: ' . _BASE_PATH . 'admin/profile');
                    exit;
                }
                include _PUBLIC_PATH . 'core/include/login.php';
                break;
            case "profile":
                if (User::isLoggedIn() && $selector && $token) {
                    include _PUBLIC_PATH . 'core/include/login.php';
                }
                break;
        }
        if (!User::isLoggedIn() && !in_array($id, ['login', 'reset', 'register'])) {
            header('location:' . _BASE_PATH . 'admin/login');
            exit;
        }
        if (User::isLoggedIn() && in_array($id, ['setting', 'plugin', 'register', 'reset', 'template', 'user'])) {
            if (!User::canEditAsAdmin()) {
                header('location:' . _BASE_PATH . 'admin/profile');
                exit;
            }
        }
    });

});

// -- 404
$router->set404(function () {
    header('HTTP/1.1 404 Not Found');
});
