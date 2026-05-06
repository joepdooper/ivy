<?php

use Ivy\Routing\Route;
use Ivy\View\View;

// -- HOME
Route::get('/', function () {
    View::render('include/main.latte');
})
    ->before('\Ivy\Controller\TemplateController@before');
// -- PROFILE
Route::get('/profile/(\d+)', '\Ivy\Controller\ProfileController@public')
    ->before('\Ivy\Controller\TemplateController@before');