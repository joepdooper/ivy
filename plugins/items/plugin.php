<?php

use Ivy\Manager\RouterManager;

RouterManager::instance()->get('/', '\Items\ItemController@index');
RouterManager::instance()->post('/item_template/insert', '\Items\ItemController@post');