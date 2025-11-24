<?php

use Ivy\Manager\RouterManager;

RouterManager::instance()->match('GET|POST','/', '\Items\ItemController@index');

RouterManager::instance()->mount('/item', function () {
    RouterManager::instance()->post('/save/(\d+)', '\Items\ItemController@save');
    RouterManager::instance()->post('/update/(\d+)', '\Items\ItemController@update');
});