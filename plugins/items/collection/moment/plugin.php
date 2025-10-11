<?php

use Ivy\Manager\AssetManager;
use Ivy\Manager\RouterManager;
use Ivy\Model\User;

if (User::canEditAsEditor()) {
    AssetManager::addViteEntry("plugins/items/collection/moment/js/moment_admin.js");
}

RouterManager::instance()->match('GET|POST', '/moment/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Moment\MomentController@insert');

RouterManager::instance()->post('/moment/create/', '\Items\Collection\Moment\MomentController@create');
RouterManager::instance()->post('/moment/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Moment\MomentController@save');
RouterManager::instance()->post('/moment/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Moment\MomentController@update');
RouterManager::instance()->post('/moment/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Moment\MomentController@delete');