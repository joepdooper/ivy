<?php

use Ivy\Shared\Presentation\Routing\Route;
use Ivy\Template\Presentation\View\View;

// -- HOME
Route::get('/', function () {
    View::render('include/main.latte');
})->before('\Ivy\Template\Presentation\Controller\TemplateController@before');
// -- PROFILE
Route::get('/profile/(\d+)', 'Ivy\User\Presentation\Controller\ProfileController@public')
    ->before('\Ivy\Template\Presentation\Controller\TemplateController@before');