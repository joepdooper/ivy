<?php

use Ivy\App;
use Ivy\Path;
use Ivy\Setting;
use Ivy\Template;
use Ivy\User;

// BEFORE MIDDLEWARE

App::router()->before('GET', '/.*', function () {
    if (!User::isLoggedIn() && Setting::getStash()['private']->getBool()) {
        if (Path::get('CURRENT_PAGE') != Path::get('BASE_PATH') . 'admin/login') {
            header('location:' . Path::get('BASE_PATH') . 'admin/login');
            exit;
        }
    }
});

App::router()->before('GET|POST', '/admin/([a-z0-9_-]+)', function ($id) {
    if (User::isLoggedIn()) {
        if (!User::canEditAsAdmin() && !in_array($id, ['register', 'login', 'logout', 'reset', 'profile'])) {
            header('location:' . Path::get('BASE_PATH'));
            exit();
        }
    } else {
        if (!in_array($id, ['register', 'login', 'reset'])) {
            header('location:' . Path::get('BASE_PATH') . 'admin/login');
            exit();
        }
    }
});

App::router()->before('GET|POST', '/plugin/.*', function () {
    if (User::isLoggedIn()) {
        if (!User::canEditAsSuperAdmin()) {
            header('location:' . Path::get('BASE_PATH'));
            exit();
        }
    } else {
        header('location:' . Path::get('BASE_PATH') . 'admin/login');
    }
});

App::router()->before('GET|POST', '/([a-z0-9_-]+)/([a-z0-9_-]+)', function ($route, $identifier) {
    Template::$route = htmlentities($route);
    Template::$identifier = htmlentities($identifier);
    Template::$url = DIRECTORY_SEPARATOR . Template::$route . DIRECTORY_SEPARATOR . Template::$identifier;
});