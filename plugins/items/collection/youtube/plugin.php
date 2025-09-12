<?php

use Ivy\Manager\AssetManager;
use Ivy\Manager\HookManager;
use Ivy\Manager\RouterManager;
use Ivy\Manager\SecurityManager;
use Ivy\Manager\SessionManager;

AssetManager::addCSS("plugins/items/collection/youtube/css/youtube.css");

HookManager::add('after_footer', function () {
    if(in_array("IframeManager", SessionManager::get('plugin_actives'))){
        if (isset($_COOKIE['cc_cookie'])){
            $cc_cookie = json_decode($_COOKIE['cc_cookie']);
            $cc_cookie->necessary = in_array("necessary", $cc_cookie->categories);
            $cc_cookie->analytics = in_array("analytics", $cc_cookie->categories);
            $cc_cookie->targeting = in_array("targeting", $cc_cookie->categories);
        }
        $scriptAttribute = (isset($cc_cookie) && $cc_cookie->analytics) ?: "type='text/plain' data-cookiecategory='analytics'";
        print "<script nonce='" . SecurityManager::getNonce() . "' {$scriptAttribute} src='https://www.youtube.com/player_api'></script>";
        AssetManager::addJS("plugins/items/collection/youtube/js/youtube.js");
    } else {
        print "<script nonce='" . SecurityManager::getNonce() . "' src='https://www.youtube.com/player_api'></script>";
        AssetManager::addJS("plugins/items/collection/youtube/js/youtube.js");
    }
});

RouterManager::instance()->match('GET|POST', '/youtube/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Youtube\YoutubeController@insert');

RouterManager::instance()->post('/youtube/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Youtube\YoutubeController@save');
RouterManager::instance()->post('/youtube/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Youtube\YoutubeController@update');
RouterManager::instance()->post('/youtube/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Youtube\YoutubeController@delete');