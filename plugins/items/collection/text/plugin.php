<?php

use Ivy\Manager\AssetManager;
use Ivy\Manager\Hookmanager;
use Ivy\Manager\RouterManager;
use Ivy\Model\User;
use Ivy\Path;
use Ivy\View\LatteView;

AssetManager::addCSS(Path::get('PLUGIN_PATH') . "items/collection/text/css/text.css");
AssetManager::addJS("node_modules/linkifyjs/dist/linkify.min.js");
AssetManager::addJS("node_modules/linkify-html/dist/linkify-html.min.js");
AssetManager::addJS(Path::get('PLUGIN_PATH') . "items/collection/text/js/text.js");

if (User::canEditAsEditor()) {
    AssetManager::addJS(Path::get('PLUGIN_PATH') . "items/collection/text/js/text_admin.js");
    Hookmanager::add('before_footer', function () {
        LatteView::render(Path::get('PLUGIN_PATH') . 'items/collection/text/template/toolbar.latte');
    });
}

RouterManager::instance()->match('GET|POST', '/text/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Text\TextController@insert');

RouterManager::instance()->post('/text/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Text\TextController@save');
RouterManager::instance()->post('/text/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Text\TextController@update');
RouterManager::instance()->post('/text/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Text\TextController@delete');