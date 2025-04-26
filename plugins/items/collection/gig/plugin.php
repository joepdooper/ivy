<?php

use Ivy\Manager\AssetManager;
use Ivy\Manager\RouterManager;
use Ivy\Path;

AssetManager::addCSS(Path::get('PLUGIN_PATH') . "gig/css/gig.css");

RouterManager::instance()->match('GET|POST', '/gig/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Gig\GigController@insert');

RouterManager::instance()->post('/gig/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Gig\GigController@save');
RouterManager::instance()->post('/gig/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Gig\GigController@update');
RouterManager::instance()->post('/gig/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Gig\GigController@delete');