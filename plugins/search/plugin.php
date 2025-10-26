<?php

use Ivy\Manager\RouterManager;

RouterManager::instance()->post('/search/post', '\Search\SearchController@post');