<?php

use Ivy\Shared\Presentation\Routing\Route;

Route::mount('/user', function () {
    // -- USER register
    Route::post('/register', '\Ivy\User\Presentation\Controller\UserController@register')
        ->before('\Ivy\User\Presentation\Controller\UserController@beforeRegister');
    Route::get('/register', '\Ivy\User\Presentation\Controller\UserController@viewRegister')
        ->before('\Ivy\User\Presentation\Controller\UserController@beforeRegister');

    // -- USER login
    Route::post('/login', '\Ivy\User\Presentation\Controller\UserController@login')
        ->before('\Ivy\User\Presentation\Controller\UserController@beforeLogin');
    Route::get('/login(/[^/]+)?(/[^/]+)?', '\Ivy\User\Presentation\Controller\UserController@viewLogin')
        ->before('\Ivy\User\Presentation\Controller\UserController@beforeLogin');

    // -- USER logout
    Route::post('/logout', '\Ivy\User\Presentation\Controller\UserController@logout');
    Route::get('/logout', '\Ivy\User\Presentation\Controller\UserController@viewLogout');

    // -- USER reset
    Route::post('/reset', '\Ivy\User\Presentation\Controller\UserController@reset')
        ->before('\Ivy\User\Presentation\Controller\UserController@beforeReset');
    Route::get('/reset(/[^/]+)?(/[^/]+)?', '\Ivy\User\Presentation\Controller\UserController@viewReset')
        ->before('\Ivy\User\Presentation\Controller\UserController@beforeReset');
});