<?php

use Ivy\Manager\RouterManager;

RouterManager::instance()->mount('/user', function () {
    // -- USER register
    RouterManager::instance()->post('register', '\Ivy\Controller\UserController@register');
    RouterManager::instance()->get('register', '\Ivy\Controller\UserController@viewRegister');
    // -- USER login
    RouterManager::instance()->post('login', '\Ivy\Controller\UserController@login');
    RouterManager::instance()->get('login(/[^/]+)?(/[^/]+)?', '\Ivy\Controller\UserController@viewLogin');
    // -- USER logout
    RouterManager::instance()->post('logout', '\Ivy\Controller\UserController@logout');
    RouterManager::instance()->get('logout', '\Ivy\Controller\UserController@viewLogout');
    // -- USER reset
    RouterManager::instance()->post('reset', '\Ivy\Controller\UserController@reset');
    RouterManager::instance()->get('reset(/[^/]+)?(/[^/]+)?', '\Ivy\Controller\UserController@viewReset');
});