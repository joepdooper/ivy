<?php

use Ivy\Manager\RouterManager;

RouterManager::instance()->get('/article/([a-z0-9_-]+)', '\Items\Collection\Article\ArticleController@page');
RouterManager::instance()->match('GET|POST', '/article/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Article\ArticleController@save');
RouterManager::instance()->match('GET|POST', '/article/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Article\ArticleController@insert');
RouterManager::instance()->match('GET|POST', '/article/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Article\ArticleController@update');
RouterManager::instance()->match('GET|POST', '/article/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Article\ArticleController@delete');