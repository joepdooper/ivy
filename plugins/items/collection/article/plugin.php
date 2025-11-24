<?php

use Items\Collection\Article\Article;
use Items\ItemRegistry;
use Ivy\Manager\RouterManager;

RouterManager::instance()->mount('/article', function () {
    RouterManager::instance()->get('/([a-z0-9_-]+)', '\Items\Collection\Article\ArticleTemplate@page');
    RouterManager::instance()->match('GET|POST', '/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Article\ArticleController@insert');
    RouterManager::instance()->post('/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Article\ArticleController@save');
    RouterManager::instance()->post('/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Article\ArticleController@update');
    RouterManager::instance()->post('/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Article\ArticleController@delete');
});

ItemRegistry::register('article', Article::class);