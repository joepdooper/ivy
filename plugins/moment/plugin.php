<?php

use Items\ItemRegistry;
use Ivy\Routing\Route;
use Moment\Moment;

//    RouterManager::instance()->before('GET', '/.*', function () {
//        $uri = RouterManager::instance()->getCurrentUri();
//
//        $assetMap = [
//            '/' => 'plugins/moment/js/add_moment_admin.js',
//            '/moment/*' => 'plugins/moment/js/add_moment_admin.js',
//        ];
//
//        foreach ($assetMap as $pattern => $asset) {
//            if (fnmatch($pattern, $uri)) {
//                AssetManager::addJS($asset);
//            }
//        }
//    });

Route::mount('/moment', function () {
    Route::get('/([a-z0-9_-]+)', '\Moment\MomentTemplate@page')
        ->before('\Ivy\Controller\AdminController@before');
    Route::post('/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Moment\MomentTemplate@insert')
        ->before('\Ivy\Controller\AdminController@before');
    Route::post('/create', '\Moment\MomentController@create')
        ->before('\Ivy\Controller\AdminController@before');
    Route::post('/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Moment\MomentController@save')
        ->before('\Ivy\Controller\AdminController@before');
    Route::post('/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Moment\MomentController@update')
        ->before('\Ivy\Controller\AdminController@before');
    Route::post('/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Moment\MomentController@delete')
        ->before('\Ivy\Controller\AdminController@before');
});

ItemRegistry::register('moment', Moment::class);
