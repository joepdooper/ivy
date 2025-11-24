<?php

use Items\Collection\Article\Article;
use Items\ItemRegistry;
use Ivy\Manager\AssetManager;
use Ivy\Manager\RouterManager;
use Ivy\Model\User;

AssetManager::addCSS("plugins/items/collection/audio/css/audio.css");

if (User::canEditAsEditor()) {
    AssetManager::addViteEntry("plugins/items/collection/audio/js/audio_admin.js");
}

RouterManager::instance()->mount('/audio', function () {
    RouterManager::instance()->match('GET|POST', '/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Audio\AudioController@insert');
    RouterManager::instance()->post('/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Audio\AudioController@save');
    RouterManager::instance()->post('/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Audio\AudioController@update');
    RouterManager::instance()->post('/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Audio\AudioController@delete');
});

ItemRegistry::register('article', Article::class);