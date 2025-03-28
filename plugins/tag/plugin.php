<?php

use Ivy\App;
use Ivy\Manager\AssetManager;

AssetManager::addCSS("plugins/tag/css/tag.css");

App::router()->get('/plugin/tag/manage','\Tag\TagController@index');
App::router()->post('/tag/post', '\Tag\TagController@post');