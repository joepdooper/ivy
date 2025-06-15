<?php

use Ivy\Manager\RouterManager;

RouterManager::instance()->get('/', '\Timeline\TimelineController@index');

RouterManager::instance()->match('GET|POST', '/timeline/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Timeline\TimelineController@insert');

RouterManager::instance()->post('/timeline/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Timeline\TimelineController@save');
RouterManager::instance()->post('/timeline/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Timeline\TimelineController@update');
RouterManager::instance()->post('/timeline/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Timeline\TimelineController@delete');