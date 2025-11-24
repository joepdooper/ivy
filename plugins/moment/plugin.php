<?php

use Items\ItemRegistry;
use Ivy\Manager\AssetManager;
use Ivy\Manager\RouterManager;
use Ivy\Model\User;
use Moment\Moment;

if (User::canEditAsEditor()) {
    RouterManager::instance()->before('GET', '/.*', function() {
        $uri = RouterManager::instance()->getCurrentUri();

        $assetMap = [
            '/'         => 'plugins/moment/js/add_moment_admin.js',
            '/moment/*' => 'plugins/moment/js/add_moment_admin.js',
        ];

        foreach ($assetMap as $pattern => $asset) {
            if (fnmatch($pattern, $uri)) {
                AssetManager::addViteEntry($asset);
            }
        }
    });
}

RouterManager::instance()->mount('/moment', function () {
    RouterManager::instance()->get('/([a-z0-9_-]+)', '\Moment\MomentTemplate@page');
    RouterManager::instance()->match('GET|POST', '/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Moment\MomentController@insert');
    RouterManager::instance()->post('/create', '\Moment\MomentController@create');
    RouterManager::instance()->post('/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Moment\MomentController@save');
    RouterManager::instance()->post('/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Moment\MomentController@update');
    RouterManager::instance()->post('/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Moment\MomentController@delete');
});

ItemRegistry::register('moment', Moment::class);