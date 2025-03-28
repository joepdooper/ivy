<?php

use Ivy\App;

App::router()->mount('/admin', function () {
    // -- USER register
    App::router()->post('/user/register', '\Ivy\Controller\UserController@register');
    App::router()->get('/register', '\Ivy\Controller\UserController@viewRegister');
    // -- USER login
    App::router()->post('/user/login', '\Ivy\Controller\UserController@login');
    App::router()->get('/login(/[^/]+)?(/[^/]+)?', '\Ivy\Controller\UserController@viewLogin');
    // -- USER logout
    App::router()->post('/user/logout', '\Ivy\Controller\UserController@logout');
    App::router()->get('/logout', '\Ivy\Controller\UserController@viewLogout');
    // -- USER reset
    App::router()->post('/user/reset', '\Ivy\Controller\UserController@reset');
    App::router()->get('/reset(/[^/]+)?(/[^/]+)?', '\Ivy\Controller\UserController@viewReset');
    // -- USER profile
    App::router()->post('/profile/post', '\Ivy\Controller\ProfileController@post');
    App::router()->get('/profile', '\Ivy\Controller\ProfileController@user');
    // -- USER index
    App::router()->post('/user/post', '\Ivy\Controller\UserController@post');
    App::router()->get('/user', '\Ivy\Controller\UserController@index');
    // -- PLUGIN index
    App::router()->post('/plugin/post', '\Ivy\Controller\PluginController@post');
    App::router()->get('/plugin(/[a-z0-9_-]+)?(/collection)?', '\Ivy\Controller\PluginController@index');
    // -- TEMPLATE index
    App::router()->post('/template/post', '\Ivy\Controller\TemplateController@post');
    App::router()->get('/template', '\Ivy\Controller\TemplateController@index');
    // -- SETTING index
    App::router()->post('/setting/post', '\Ivy\Controller\SettingController@post');
    App::router()->get('/setting', '\Ivy\Controller\SettingController@index');;
});
