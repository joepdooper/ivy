<?php

use Ivy\Manager\AssetManager;
use Ivy\Model\User;
use Ivy\Routing\Route;

if (User::canEditAsEditor()) {
    AssetManager::addJS('plugins/contacts/js/contacts_admin.js');
}

Route::mount('/admin/plugin/contacts', function () {
    Route::get('/index', '\Contacts\ContactController@index')
        ->before('\Ivy\Controller\AdminController@before');
    Route::post('/sync', '\Contacts\ContactController@sync')
        ->before('\Ivy\Controller\AdminController@before');
});
