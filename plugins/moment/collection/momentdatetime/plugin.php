<?php

use Ivy\Manager\AssetManager;
use Ivy\Manager\RouterManager;
use Ivy\Model\User;

if (User::canEditAsEditor()) {
    AssetManager::addViteEntry("plugins/moment/collection/momentdatetime/js/calendar_admin.js");
}

RouterManager::instance()->mount('/moment', function () {
    RouterManager::instance()->get('/([a-z0-9_-]+)', '\Moment\MomentTemplate@page');

    RouterManager::instance()->match('GET|POST', '/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Moment\MomentController@insert');

    RouterManager::instance()->post('/create/', '\Moment\MomentController@create');
    RouterManager::instance()->post('/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Moment\MomentController@save');
    RouterManager::instance()->post('/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Moment\MomentController@update');
    RouterManager::instance()->post('/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Moment\MomentController@delete');
});