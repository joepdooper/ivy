<?php

use Ivy\App;

App::router()->mount('/admin', function () {
    // -- USER register
    App::router()->post('/user/register', '\Ivy\UserController@register');
    App::router()->get('/register', '\Ivy\UserController@viewRegister');
    // -- USER login
    App::router()->post('/user/login', '\Ivy\UserController@login');
    App::router()->get('/login(/[^/]+)?(/[^/]+)?', '\Ivy\UserController@viewLogin');
    // -- USER logout
    App::router()->post('/user/logout', '\Ivy\UserController@logout');
    App::router()->get('/logout', '\Ivy\UserController@viewLogout');
    // -- USER reset
    App::router()->post('/user/reset', '\Ivy\UserController@reset');
    App::router()->get('/reset(/[^/]+)?(/[^/]+)?', '\Ivy\UserController@viewReset');
    // -- USER profile
    App::router()->post('/profile/post', '\Ivy\ProfileController@post');
    App::router()->get('/profile', '\Ivy\ProfileController@user');
    // -- USER index
    App::router()->post('/user/post', '\Ivy\UserController@post');
    App::router()->get('/user', '\Ivy\UserController@index');
    // -- PLUGIN index
    App::router()->post('/plugin/post', '\Ivy\PluginController@post');
    App::router()->get('/plugin(/[a-z0-9_-]+)?(/collection)?', '\Ivy\PluginController@index');
    // -- TEMPLATE index
    App::router()->post('/template/post', '\Ivy\TemplateController@post');
    App::router()->get('/template', '\Ivy\TemplateController@index');
    // -- SETTING index
    App::router()->post('/setting/post', '\Ivy\SettingController@post');
    App::router()->get('/setting', '\Ivy\SettingController@index');;
});
