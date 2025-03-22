<?php

use Ivy\App;

// BEFORE MIDDLEWARE
App::router()->before('GET', '/.*', '\Ivy\TemplateController@before');
App::router()->mount('/admin', function () {
    App::router()->before('GET', '/', '\Ivy\UserController@before');
    App::router()->before('GET|POST', '/register', '\Ivy\UserController@beforeRegister');
    App::router()->before('GET|POST', '/login', '\Ivy\UserController@beforeLogin');
    App::router()->before('GET|POST', '/logout', '\Ivy\UserController@beforeLogout');
    App::router()->before('GET|POST', '/reset', '\Ivy\UserController@beforeReset');
    App::router()->before('GET|POST', '/profile', '\Ivy\ProfileController@before');
});
App::router()->before('GET|POST', '/plugin/.*', '\Ivy\PluginController@before');
App::router()->before('GET|POST', '/([a-z0-9_-]+)/([a-z0-9_-]+)', '\Ivy\TemplateController@dynamicRoute');