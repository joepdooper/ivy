<?php

use Ivy\Manager\AssetManager;
use Ivy\Manager\RouterManager;
use Ivy\Routing\Route;

AssetManager::addCSS('plugins/tags/css/tag.css');

Route::mount('/admin/plugin/tags', function () {
    Route::post('/manage', '\Tags\TagController@index')
        ->before('\Ivy\Controller\AdminController@before');
    Route::post('/sync', '\Tags\TagController@sync')
        ->before('\Ivy\Controller\AdminController@before');
});