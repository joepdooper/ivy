<?php

use Ivy\Manager\AssetManager;
use Ivy\Manager\RouterManager;
use Ivy\Model\User;

if (User::canEditAsEditor()) {
    AssetManager::addViteEntry("plugins/moment/collection/momentlocation/js/location_admin.js");
}

RouterManager::instance()->mount('/momentlocation', function () {
    RouterManager::instance()->match('GET|POST', '/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Moment\Collection\MomentLocationController@insert');

    RouterManager::instance()->post('/create/', '\Moment\Collection\MomentLocationController@create');
    RouterManager::instance()->post('/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Moment\Collection\MomentLocationController@save');
    RouterManager::instance()->post('/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Moment\Collection\MomentLocationController@update');
    RouterManager::instance()->post('/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Moment\Collection\MomentLocationController@delete');
});