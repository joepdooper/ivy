<?php

use Ivy\Manager\AssetManager;
use Ivy\Manager\RouterManager;
use Ivy\Path;

AssetManager::addCSS(Path::get('PLUGIN_PATH') . "items/collection/code/css/code.css");
AssetManager::addJS(Path::get('PLUGIN_PATH') . "items/collection/code/js/rainbow.min.js");

RouterManager::instance()->match('GET|POST', '/code/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Code\CodeController@insert');

RouterManager::instance()->post('/code/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Code\CodeController@save');
RouterManager::instance()->post('/code/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Code\CodeController@update');
RouterManager::instance()->post('/code/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Code\CodeController@delete');