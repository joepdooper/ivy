<?php

use Ivy\Manager\RouterManager;

RouterManager::instance()->mount('/admin/plugin/moment/collection/momentpeople', function () {
    RouterManager::instance()->get('/index', '\Moment\Collection\MomentPeople\MomentPeopleController@index');
    RouterManager::instance()->post('/post', '\Moment\Collection\MomentPeople\MomentPeopleController@post');
});