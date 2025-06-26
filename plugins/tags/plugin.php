<?php

use Ivy\Manager\AssetManager;
use Ivy\Manager\RouterManager;

AssetManager::addCSS("plugins/tags/css/tag.css");

RouterManager::instance()->get('/admin/plugin/tags/manage','\Tags\TagController@index');
RouterManager::instance()->post('/tags/post', '\Tags\TagController@post');