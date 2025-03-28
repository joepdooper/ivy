<?php

use Ivy\App;

// BEFORE MIDDLEWARE
App::router()->before('GET', '/.*', '\Ivy\Controller\TemplateController@before');
App::router()->mount('/admin', function () {
    App::router()->before('GET', '/', '\Ivy\Controller\UserController@before');
    App::router()->before('GET|POST', '/register', '\Ivy\Controller\UserController@beforeRegister');
    App::router()->before('GET|POST', '/login', '\Ivy\Controller\UserController@beforeLogin');
    App::router()->before('GET|POST', '/logout', '\Ivy\Controller\UserController@beforeLogout');
    App::router()->before('GET|POST', '/reset', '\Ivy\Controller\UserController@beforeReset');
    App::router()->before('GET|POST', '/profile', '\Ivy\Controller\ProfileController@before');
});
App::router()->before('GET|POST', '/plugin/.*', '\Ivy\Controller\PluginController@before');