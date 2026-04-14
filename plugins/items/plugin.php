<?php

use Ivy\Routing\Route;

Route::get('/', '\Items\ItemController@index')
    ->before('\Ivy\Controller\AdminController@before');

Route::mount('/item', function () {
    Route::post('/save/(\d+)', '\Items\ItemController@save')
        ->before('\Ivy\Controller\AdminController@before');
    Route::post('/update/(\d+)', '\Tags\TagController@update')
        ->before('\Ivy\Controller\AdminController@before');
    Route::post('/insert', '\Tags\TagController@insert')
        ->before('\Ivy\Controller\AdminController@before');
});
