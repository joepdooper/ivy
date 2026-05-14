<?php

use Ivy\Shared\Presentation\Routing\Route;

Route::mount('/user', function () {
    // -- USER register
    Route::post('/register', '\Ivy\Controller\UserController@register')
        ->before('\Ivy\Controller\UserController@beforeRegister');
    Route::get('/register', '\Ivy\Controller\UserController@viewRegister')
        ->before('\Ivy\Controller\UserController@beforeRegister');

    // -- USER login
    Route::post('/login', '\Ivy\Controller\UserController@login')
        ->before('\Ivy\Controller\UserController@beforeLogin');
    Route::get('/login(/[^/]+)?(/[^/]+)?', '\Ivy\Controller\UserController@viewLogin')
        ->before('\Ivy\Controller\UserController@beforeLogin');

    // -- USER logout
    Route::post('/logout', '\Ivy\Controller\UserController@logout');
    Route::get('/logout', '\Ivy\Controller\UserController@viewLogout');

    // -- USER reset
    Route::post('/reset', '\Ivy\Controller\UserController@reset')
        ->before('\Ivy\Controller\UserController@beforeReset');
    Route::get('/reset(/[^/]+)?(/[^/]+)?', '\Ivy\Controller\UserController@viewReset')
        ->before('\Ivy\Controller\UserController@beforeReset');
});