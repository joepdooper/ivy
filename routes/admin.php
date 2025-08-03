<?php

use Ivy\Manager\RouterManager;

RouterManager::instance()->mount('/admin', function () {
    // -- USER profile
    RouterManager::instance()->post('/profile/post', '\Ivy\Controller\ProfileController@post');
    RouterManager::instance()->get('/profile', '\Ivy\Controller\ProfileController@user');
    RouterManager::instance()->get('/profile(/[^/]+)?(/[^/]+)?', '\Ivy\Controller\ProfileController@verify');
    // -- USER index
    RouterManager::instance()->post('/user/post', '\Ivy\Controller\UserController@post');
    RouterManager::instance()->get('/user', '\Ivy\Controller\UserController@index');
    // -- PLUGIN index
    RouterManager::instance()->post('/plugin/post', '\Ivy\Controller\PluginController@post');
    RouterManager::instance()->get('/plugin/([a-z0-9_-]+)/settings', '\Ivy\Controller\SettingController@index');
    RouterManager::instance()->get('/plugin(/[a-z0-9_-]+)?(/collection)?', '\Ivy\Controller\PluginController@index');
    // -- TEMPLATE index
    RouterManager::instance()->post('/template/post', '\Ivy\Controller\TemplateController@post');
    RouterManager::instance()->get('/template', '\Ivy\Controller\TemplateController@index');
    // -- SETTING index
    RouterManager::instance()->post('/setting/post', '\Ivy\Controller\SettingController@post');
    RouterManager::instance()->get('/setting', '\Ivy\Controller\SettingController@index');
    // -- INFO index
    RouterManager::instance()->post('/info/post', '\Ivy\Controller\InfoController@post');
    RouterManager::instance()->get('/info', '\Ivy\Controller\InfoController@index');
});
