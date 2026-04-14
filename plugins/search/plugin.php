<?php

use Ivy\Routing\Route;

Route::mount('/search', function () {
    Route::post('/post', '\Search\SearchController@post')
        ->before('\Ivy\Controller\AdminController@before');
});