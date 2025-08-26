<?php

use Ivy\Manager\RouterManager;

RouterManager::instance()->get('/article/([a-z0-9_-]+)', '\Items\Collection\Article\ArticleTemplate@page');

RouterManager::instance()->match('GET|POST', '/article/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Article\ArticleController@insert');

RouterManager::instance()->post('/article/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Article\ArticleController@save');
RouterManager::instance()->post('/article/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Article\ArticleController@update');
RouterManager::instance()->post('/article/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Article\ArticleController@delete');