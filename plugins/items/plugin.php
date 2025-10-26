<?php

use Ivy\Manager\RouterManager;

RouterManager::instance()->get('/', '\Items\ItemController@index');
RouterManager::instance()->post('/item_template/insert', '\Items\ItemController@post');

RouterManager::instance()->post('/item/save/(\d+)', '\Items\ItemController@save');
RouterManager::instance()->post('/item/update/(\d+)', '\Items\ItemController@update');
