<?php


use Ivy\Shared\Presentation\Routing\Route;

Route::mount('/admin', function () {
    // -- USER profile
    Route::post('/profile/save', '\Ivy\User\Presentation\Controller\ProfileController@save')
        ->before('\Ivy\User\Presentation\Controller\AdminController@before');
    Route::get('/profile', '\Ivy\User\Presentation\Controller\ProfileController@user')
        ->before('\Ivy\User\Presentation\Controller\AdminController@before');
    Route::get('/profile(/[^/]+)?(/[^/]+)?', '\Ivy\User\Presentation\Controller\ProfileController@verify')
        ->before('\Ivy\User\Presentation\Controller\AdminController@before');
    // -- USER index
    Route::post('/user/sync', '\Ivy\User\Presentation\Controller\UserController@sync')
        ->before('\Ivy\User\Presentation\Controller\AdminController@before');
    Route::get('/user', '\Ivy\User\Presentation\Controller\UserController@index')
        ->before('\Ivy\User\Presentation\Controller\AdminController@before');
    // -- PLUGIN index
    Route::post('/plugin/sync', '\Ivy\Plugin\Presentation\Controller\PluginController@sync')
        ->before('\Ivy\User\Presentation\Controller\AdminController@before');
    Route::get('/plugin/([a-z0-9_-]+)/settings', '\Ivy\Setting\Presentation\Controller\SettingController@index')
        ->before('\Ivy\User\Presentation\Controller\AdminController@before');
    Route::get('/plugin(/[a-z0-9_-]+)?(/collection)?', '\Ivy\Plugin\Presentation\Controller\PluginController@index')
        ->before('\Ivy\User\Presentation\Controller\AdminController@before');
    // -- TEMPLATE index
    Route::post('/template/sync', '\Ivy\Template\Presentation\Controller\TemplateController@sync')
        ->before('\Ivy\User\Presentation\Controller\AdminController@before');
    Route::get('/template', '\Ivy\Template\Presentation\Controller\TemplateController@index')
        ->before('\Ivy\User\Presentation\Controller\AdminController@before');
    // -- SETTING index
    Route::post('/setting/sync', '\Ivy\Setting\Presentation\Controller\SettingController@sync')
        ->before('\Ivy\User\Presentation\Controller\AdminController@before');
    Route::get('/setting', '\Ivy\Setting\Presentation\Controller\SettingController@index')
        ->before('\Ivy\User\Presentation\Controller\AdminController@before');
    // -- INFO index
    Route::post('/info/sync', '\Ivy\Setting\Presentation\Controller\InfoController@sync')
        ->before('\Ivy\User\Presentation\Controller\AdminController@before');
    Route::get('/info', '\Ivy\Setting\Presentation\Controller\InfoController@index')
        ->before('\Ivy\User\Presentation\Controller\AdminController@before');
});