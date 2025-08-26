<?php

use Ivy\Manager\AssetManager;
use Ivy\Manager\RouterManager;
use Ivy\Model\User;
use Ivy\Core\Path;

AssetManager::addCSS("plugins/items/collection/audio/css/audio.css");

if (User::canEditAsEditor()) {
    AssetManager::addJS("plugins/items/collection/audio/js/audio_admin.js");
}

RouterManager::instance()->match('GET|POST', '/audio/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Audio\AudioController@insert');

RouterManager::instance()->post('/audio/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Audio\AudioController@save');
RouterManager::instance()->post('/audio/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Audio\AudioController@update');
RouterManager::instance()->post('/audio/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Audio\AudioController@delete');