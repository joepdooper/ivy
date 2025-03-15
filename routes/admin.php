<?php

use Ivy\App;
use Ivy\Path;
use Ivy\User;

App::router()->mount('/admin', function () {

    App::router()->post('/user/register', '\Ivy\UserController@register');

    App::router()->post('/user/login', '\Ivy\UserController@login');

    App::router()->post('/user/logout', '\Ivy\UserController@logout');

    App::router()->post('/user/reset', '\Ivy\UserController@reset');

    App::router()->post('/user/post', '\Ivy\UserController@post');

    App::router()->post('/plugin/post', '\Ivy\PluginController@post');

    App::router()->post('/profile/post', '\Ivy\ProfileController@post');

    App::router()->post('/setting/post', '\Ivy\SettingController@post');

    App::router()->post('/template/post', '\Ivy\TemplateController@post');

    App::router()->get('/(\w+)(/[^/]+)?(/[^/]+)?', function ($id, $selector = null, $token = null) {
        switch ($id) {
            case "reset":
                if (User::getAuth()->isLoggedIn()) {
                    header('location: ' . Path::get('BASE_PATH') . 'admin/profile');
                    exit;
                }
                include Path::get('PUBLIC_PATH') . 'include/reset.php';
                break;
            case "login":
                if (User::getAuth()->isLoggedIn()) {
                    header('location: ' . Path::get('BASE_PATH') . 'admin/profile');
                    exit;
                }
                include Path::get('PUBLIC_PATH') . 'include/login.php';
                break;
            case "profile":
                if (User::getAuth()->isLoggedIn() && $selector && $token) {
                    include Path::get('PUBLIC_PATH') . 'include/login.php';
                }
                break;
        }
        if (!User::getAuth()->isLoggedIn() && !in_array($id, ['login', 'reset', 'register'])) {
            header('location:' . Path::get('BASE_PATH') . 'admin/login');
            exit;
        }
        if (User::getAuth()->isLoggedIn() && in_array($id, ['setting', 'plugin', 'register', 'reset', 'template', 'user'])) {
            if (!User::canEditAsAdmin()) {
                header('location:' . Path::get('BASE_PATH') . 'admin/profile');
                exit;
            }
        }
    });

});
