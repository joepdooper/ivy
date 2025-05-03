<?php

use Ivy\Manager\RouterManager;

RouterManager::instance()->get('/documentation/([a-z0-9_-]+)', '\Items\Collection\Documentation\DocumentationTemplate@page');

RouterManager::instance()->match('GET|POST', '/documentation/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Documentation\DocumentationController@insert');

RouterManager::instance()->post('/documentation/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Documentation\DocumentationController@save');
RouterManager::instance()->post('/documentation/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Documentation\DocumentationController@update');
RouterManager::instance()->post('/documentation/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Documentation\DocumentationController@delete');