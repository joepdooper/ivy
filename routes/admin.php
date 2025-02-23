<?php

use Ivy\App;
use Ivy\Path;
use Ivy\Setting;
use Ivy\Template;
use Ivy\User;

App::router()->mount('/admin', function () {

    App::router()->before('GET', '/', function () {
        header('location:' . Path::get('BASE_PATH') . 'admin/login');
        exit;
    });

    App::router()->post('/user/register', '\Ivy\User@register');

    App::router()->post('/user/login', '\Ivy\User@login');

    App::router()->post('/user/logout', '\Ivy\User@logout');

    App::router()->post('/user/reset', '\Ivy\User@reset');

    App::router()->post('/user/post', '\Ivy\UserController@post');

    App::router()->post('/plugin/post', '\Ivy\PluginController@post');

    App::router()->post('/profile/post', '\Ivy\ProfileController@post');

    App::router()->post('/setting/post', '\Ivy\SettingController@post');

    App::router()->post('/template/post', '\Ivy\Template@post');

    App::router()->get('/(\w+)(/[^/]+)?(/[^/]+)?', function ($id, $selector = null, $token = null) {
        switch ($id) {
            case "reset":
            case "login":
                if (User::isLoggedIn()) {
                    header('location: ' . Path::get('BASE_PATH') . 'admin/profile');
                    exit;
                }
                include Path::get('PUBLIC_PATH') . 'include/login.php';
                break;
            case "profile":
                if (User::isLoggedIn() && $selector && $token) {
                    include Path::get('PUBLIC_PATH') . 'include/login.php';
                }
                break;
        }
        if (!User::isLoggedIn() && !in_array($id, ['login', 'reset', 'register'])) {
            header('location:' . Path::get('BASE_PATH') . 'admin/login');
            exit;
        }
        if (User::isLoggedIn() && in_array($id, ['setting', 'plugin', 'register', 'reset', 'template', 'user'])) {
            if (!User::canEditAsAdmin()) {
                header('location:' . Path::get('BASE_PATH') . 'admin/profile');
                exit;
            }
        }
    });

});
