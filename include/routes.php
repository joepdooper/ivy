<?php

use Ivy\App;
use Ivy\Setting;
use Ivy\Template;
use Ivy\User;

// BEFORE MIDDLEWARE

App::router()->before('GET', '/.*', function () {
    if (!User::isLoggedIn() && Setting::getFromStashByKey('private')->bool) {
        if (_CURRENT_PAGE != _BASE_PATH . 'admin/login') {
            header('location:' . _BASE_PATH . 'admin/login');
            exit;
        }
    }
});

App::router()->before('GET|POST', '/admin/([a-z0-9_-]+)', function ($id) {
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

App::router()->before('GET|POST', '/plugin/.*', function () {
    if (User::isLoggedIn()) {
        if (!User::canEditAsSuperAdmin()) {
            header('location:' . _BASE_PATH);
            exit();
        }
    } else {
        header('location:' . _BASE_PATH . 'admin/login');
    }
});

App::router()->before('GET|POST', '/([a-z0-9_-]+)/([a-z0-9_-]+)', function ($route, $identifier) {
    Template::$route = htmlentities($route);
    Template::$identifier = htmlentities($identifier);
    Template::$url = DIRECTORY_SEPARATOR . Template::$route . DIRECTORY_SEPARATOR . Template::$identifier;
});

// ROUTING

// -- ADMIN
App::router()->mount('/admin', function () {

    App::router()->before('GET', '/', function () {
        header('location:' . _BASE_PATH . 'admin/login');
        exit;
    });

    App::router()->post('/user/register', '\Ivy\User@register');

    App::router()->post('/user/login', '\Ivy\User@login');

    App::router()->post('/user/logout', '\Ivy\User@logout');

    App::router()->post('/user/reset', '\Ivy\User@reset');

    App::router()->post('/user/post', '\Ivy\UserController@post');

    App::router()->post('/plugin/post', '\Ivy\PluginController@post');

    App::router()->post('/profile/post', '\Ivy\Profile@post');

    App::router()->post('/setting/post', '\Ivy\SettingController@post');

    App::router()->post('/template/post', '\Ivy\Template@post');

    App::router()->get('/(\w+)(/[^/]+)?(/[^/]+)?', function ($id, $selector = null, $token = null) {
        switch ($id) {
            case "reset":
            case "login":
                if (User::isLoggedIn()) {
                    header('location: ' . _BASE_PATH . 'admin/profile');
                    exit;
                }
                include _PUBLIC_PATH . 'include/login.php';
                break;
            case "profile":
                if (User::isLoggedIn() && $selector && $token) {
                    include _PUBLIC_PATH . 'include/login.php';
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
App::router()->set404(function () {
    header('HTTP/1.1 404 Not Found');
});
