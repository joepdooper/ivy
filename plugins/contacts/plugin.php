<?php

use Ivy\Manager\AssetManager;
use Ivy\Manager\RouterManager;
use Ivy\Model\User;

if (User::canEditAsEditor()) {
    AssetManager::addViteEntry("plugins/contacts/js/contacts_admin.js");
}

RouterManager::instance()->mount('/admin/plugin/contacts', function () {
    RouterManager::instance()->get('/index', '\Contacts\ContactController@index');
    RouterManager::instance()->post('/post', '\Contacts\ContactController@post');
});