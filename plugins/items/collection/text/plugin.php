<?php

use Ivy\Manager\AssetManager;
use Ivy\Manager\RouterManager;
use Ivy\Path;

// AssetManager::addCSS(Path::get('PLUGIN_PATH') . "items/collection/text/css/text.css");
AssetManager::addJS("node_modules/linkifyjs/dist/linkify.min.js");
AssetManager::addJS("node_modules/linkify-html/dist/linkify-html.min.js");
// AssetManager::addJS(Path::get('PLUGIN_PATH') . "items/collection/text/js/text.js");

//if (User::getAuth()->isLoggedIn()) {
//    if (User::canEditAsEditor()) {
//
//        Template::hooks()->add_action('after_body_action', function () {
//            Template::render(_PLUGIN_PATH . 'text/template/toolbar.latte');
//        });
//
//        Template::hooks()->add_action('add_js_action', function () {
//            print "<script src='" . Path::get('BASE_PATH') . _PLUGIN_PATH . "text/js/text_admin.js'></script>";
//        });
//
//    }
//}

RouterManager::instance()->match('GET|POST', '/text/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Text\TextController@insert');
RouterManager::instance()->match('GET|POST', '/text/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Text\TextController@update');
RouterManager::instance()->match('GET|POST', '/text/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Text\TextController@delete');