<?php

use Ivy\Manager\AssetManager;
use Ivy\Manager\RouterManager;
use Ivy\Manager\SessionManager;
use Ivy\Path;

AssetManager::addCSS(Path::get('PLUGIN_PATH') . "items/collection/youtube/css/youtube.css");

if(!in_array("IframeManager", SessionManager::get('plugin_actives'))) {
    AssetManager::addJS(Path::get('PLUGIN_PATH') . "items/collection/youtube/js/youtube.js");
}

RouterManager::instance()->match('GET|POST', '/youtube/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Youtube\YoutubeController@insert');

RouterManager::instance()->post('/youtube/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Youtube\YoutubeController@save');
RouterManager::instance()->post('/youtube/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Youtube\YoutubeController@update');
RouterManager::instance()->post('/youtube/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Youtube\YoutubeController@delete');