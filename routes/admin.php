<?php

use Ivy\Routing\Route;

Route::mount('/admin', function () {
    // -- USER profile
    Route::post('/profile/post', '\Ivy\Controller\ProfileController@post')
        ->before('\Ivy\Controller\AdminController@before');
    Route::get('/profile', '\Ivy\Controller\ProfileController@user')
        ->before('\Ivy\Controller\AdminController@before');
    Route::get('/profile(/[^/]+)?(/[^/]+)?', '\Ivy\Controller\ProfileController@verify')
        ->before('\Ivy\Controller\AdminController@before');
    // -- USER index
    Route::post('/user/post', '\Ivy\Controller\UserController@post')
        ->before('\Ivy\Controller\AdminController@before');
    Route::get('/user', '\Ivy\Controller\UserController@index')
        ->before('\Ivy\Controller\AdminController@before');
    // -- PLUGIN index
    Route::post('/plugin/post', '\Ivy\Controller\PluginController@post')
        ->before('\Ivy\Controller\AdminController@before');
    Route::get('/plugin/([a-z0-9_-]+)/settings', '\Ivy\Controller\SettingController@index')
        ->before('\Ivy\Controller\AdminController@before');
    Route::get('/plugin(/[a-z0-9_-]+)?(/collection)?', '\Ivy\Controller\PluginController@index')
        ->before('\Ivy\Controller\AdminController@before');
    // -- TEMPLATE index
    Route::post('/template/post', '\Ivy\Controller\TemplateController@post')
        ->before('\Ivy\Controller\AdminController@before');
    Route::get('/template', '\Ivy\Controller\TemplateController@index')
        ->before('\Ivy\Controller\AdminController@before');
    // -- SETTING index
    Route::post('/setting/post', '\Ivy\Controller\SettingController@post')
        ->before('\Ivy\Controller\AdminController@before');
    Route::get('/setting', '\Ivy\Controller\SettingController@index')
        ->before('\Ivy\Controller\AdminController@before');
    // -- INFO index
    Route::post('/info/post', '\Ivy\Controller\InfoController@post')
        ->before('\Ivy\Controller\AdminController@before');
    Route::get('/info', '\Ivy\Controller\InfoController@index')
        ->before('\Ivy\Controller\AdminController@before');
});