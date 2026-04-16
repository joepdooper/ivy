<?php

use Ivy\Routing\Route;

Route::mount('/admin/plugin/moment/collection/momentpeople', function () {
    Route::get('/index', '\Moment\Collection\MomentPeople\MomentPeopleController@index')
        ->before('\Ivy\Controller\AdminController@before');
    Route::get('/sync', '\Moment\Collection\MomentPeople\MomentPeopleController@sync')
        ->before('\Ivy\Controller\AdminController@before');
});
