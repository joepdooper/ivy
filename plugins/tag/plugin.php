<?php

use Ivy\Manager\AssetManager;
use Ivy\Manager\RouterManager;

AssetManager::addCSS("plugins/tag/css/tag.css");

RouterManager::instance()->get('/admin/plugin/tag/manage','\Tag\TagController@index');
RouterManager::instance()->post('/tag/post', '\Tag\TagController@post');