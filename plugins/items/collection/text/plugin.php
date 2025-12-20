<?php

use Items\Collection\Text\Text;
use Items\ItemRegistry;
use Ivy\Manager\AssetManager;
use Ivy\Manager\HookManager;
use Ivy\Manager\RouterManager;
use Ivy\Model\User;
use Ivy\View\View;

AssetManager::addCSS("plugins/items/collection/text/css/text.css");
AssetManager::addViteEntry("plugins/items/collection/text/js/text.js");

if (User::canEditAsEditor()) {
    AssetManager::addViteEntry("plugins/items/collection/text/js/text_admin.js");
    HookManager::add('before_footer', function () {
        View::render("plugins/items/collection/text/template/toolbar.latte");
    });
}

RouterManager::instance()->match('GET|POST', '/text/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Text\TextController@insert');

RouterManager::instance()->post('/text/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Text\TextController@save');
RouterManager::instance()->post('/text/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Text\TextController@update');
RouterManager::instance()->post('/text/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Text\TextController@delete');

ItemRegistry::register('text', Text::class);