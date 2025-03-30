<?php

use Ivy\Manager\RouterManager;

// BEFORE MIDDLEWARE
RouterManager::instance()->before('GET', '/.*', '\Ivy\Controller\TemplateController@before');
RouterManager::instance()->mount('/admin', function () {
    RouterManager::instance()->before('GET', '/', '\Ivy\Controller\UserController@before');
    RouterManager::instance()->before('GET|POST', '/register', '\Ivy\Controller\UserController@beforeRegister');
    RouterManager::instance()->before('GET|POST', '/login', '\Ivy\Controller\UserController@beforeLogin');
    RouterManager::instance()->before('GET|POST', '/logout', '\Ivy\Controller\UserController@beforeLogout');
    RouterManager::instance()->before('GET|POST', '/reset', '\Ivy\Controller\UserController@beforeReset');
    RouterManager::instance()->before('GET|POST', '/profile', '\Ivy\Controller\ProfileController@before');
});
RouterManager::instance()->before('GET|POST', '/plugin/.*', '\Ivy\Controller\PluginController@before');