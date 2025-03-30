<?php

use Ivy\Manager\RouterManager;

RouterManager::instance()->mount('/admin', function () {
    // -- USER register
    RouterManager::instance()->post('/user/register', '\Ivy\Controller\UserController@register');
    RouterManager::instance()->get('/register', '\Ivy\Controller\UserController@viewRegister');
    // -- USER login
    RouterManager::instance()->post('/user/login', '\Ivy\Controller\UserController@login');
    RouterManager::instance()->get('/login(/[^/]+)?(/[^/]+)?', '\Ivy\Controller\UserController@viewLogin');
    // -- USER logout
    RouterManager::instance()->post('/user/logout', '\Ivy\Controller\UserController@logout');
    RouterManager::instance()->get('/logout', '\Ivy\Controller\UserController@viewLogout');
    // -- USER reset
    RouterManager::instance()->post('/user/reset', '\Ivy\Controller\UserController@reset');
    RouterManager::instance()->get('/reset(/[^/]+)?(/[^/]+)?', '\Ivy\Controller\UserController@viewReset');
    // -- USER profile
    RouterManager::instance()->post('/profile/post', '\Ivy\Controller\ProfileController@post');
    RouterManager::instance()->get('/profile', '\Ivy\Controller\ProfileController@user');
    // -- USER index
    RouterManager::instance()->post('/user/post', '\Ivy\Controller\UserController@post');
    RouterManager::instance()->get('/user', '\Ivy\Controller\UserController@index');
    // -- PLUGIN index
    RouterManager::instance()->post('/plugin/post', '\Ivy\Controller\PluginController@post');
    RouterManager::instance()->get('/plugin(/[a-z0-9_-]+)?(/collection)?', '\Ivy\Controller\PluginController@index');
    // -- TEMPLATE index
    RouterManager::instance()->post('/template/post', '\Ivy\Controller\TemplateController@post');
    RouterManager::instance()->get('/template', '\Ivy\Controller\TemplateController@index');
    // -- SETTING index
    RouterManager::instance()->post('/setting/post', '\Ivy\Controller\SettingController@post');
    RouterManager::instance()->get('/setting', '\Ivy\Controller\SettingController@index');;
});
