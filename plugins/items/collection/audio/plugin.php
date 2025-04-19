<?php

use Ivy\Manager\AssetManager;
use Ivy\Manager\RouterManager;
use Ivy\Model\User;
use Ivy\Path;

AssetManager::addCSS(Path::get('PLUGIN_PATH') . "items/collection/audio/css/audio.css");

if (User::canEditAsEditor()) {
    AssetManager::addJS(Path::get('PLUGIN_PATH') . "items/collection/audio/js/audio_admin.js");
}

RouterManager::instance()->match('GET|POST', '/audio/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Audio\AudioController@save');
RouterManager::instance()->match('GET|POST', '/audio/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Audio\AudioController@insert');
RouterManager::instance()->match('GET|POST', '/audio/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Audio\AudioController@update');
RouterManager::instance()->match('GET|POST', '/audio/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Audio\AudioController@delete');