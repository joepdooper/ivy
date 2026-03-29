<?php

use Ivy\Routing\Route;

// -- HOME
Route::get('/', function () {})
    ->before('\Ivy\Controller\TemplateController@before');
// -- PROFILE
Route::get('/profile/(\d+)', '\Ivy\Controller\ProfileController@public')
    ->before('\Ivy\Controller\TemplateController@before');