<?php


use Ivy\Shared\Presentation\Routing\Route;

Route::mount('/admin', function () {
    // -- USER profile
    Route::post('/profile/save', '\Ivy\Controller\ProfileController@save')
        ->before('\Ivy\Controller\AdminController@before');
    Route::get('/profile', '\Ivy\Controller\ProfileController@user')
        ->before('\Ivy\Controller\AdminController@before');
    Route::get('/profile(/[^/]+)?(/[^/]+)?', '\Ivy\Controller\ProfileController@verify')
        ->before('\Ivy\Controller\AdminController@before');
    // -- USER index
    Route::post('/user/sync', '\Ivy\Controller\UserController@sync')
        ->before('\Ivy\Controller\AdminController@before');
    Route::get('/user', '\Ivy\Controller\UserController@index')
        ->before('\Ivy\Controller\AdminController@before');
    // -- PLUGIN index
    Route::post('/plugin/sync', '\Ivy\Controller\PluginController@sync')
        ->before('\Ivy\Controller\AdminController@before');
    Route::get('/plugin/([a-z0-9_-]+)/settings', '\Ivy\Controller\SettingController@index')
        ->before('\Ivy\Controller\AdminController@before');
    Route::get('/plugin(/[a-z0-9_-]+)?(/collection)?', '\Ivy\Controller\PluginController@index')
        ->before('\Ivy\Controller\AdminController@before');
    // -- TEMPLATE index
    Route::post('/template/sync', '\Ivy\Controller\TemplateController@sync')
        ->before('\Ivy\Controller\AdminController@before');
    Route::get('/template', '\Ivy\Controller\TemplateController@index')
        ->before('\Ivy\Controller\AdminController@before');
    // -- SETTING index
    Route::post('/setting/sync', '\Ivy\Controller\SettingController@sync')
        ->before('\Ivy\Controller\AdminController@before');
    Route::get('/setting', '\Ivy\Controller\SettingController@index')
        ->before('\Ivy\Controller\AdminController@before');
    // -- INFO index
    Route::post('/info/sync', '\Ivy\Controller\InfoController@sync')
        ->before('\Ivy\Controller\AdminController@before');
    Route::get('/info', '\Ivy\Controller\InfoController@index')
        ->before('\Ivy\Controller\AdminController@before');
});