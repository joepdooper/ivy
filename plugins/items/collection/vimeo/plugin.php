<?php

use Ivy\Manager\AssetManager;
use Ivy\Manager\HookManager;
use Ivy\Manager\RouterManager;
use Ivy\Manager\SessionManager;
use Ivy\Path;

//
//function add_vimeo_player(): void
//{
//    if (!in_array("IframeManager", $_SESSION['plugin_actives'])):
//        if (isset($_COOKIE['cc_cookie'])):
//            $cc_cookie = json_decode($_COOKIE['cc_cookie']);
//            $cc_cookie->necessary = in_array("necessary", $cc_cookie->categories);
//            $cc_cookie->analytics = in_array("analytics", $cc_cookie->categories);
//            $cc_cookie->targeting = in_array("targeting", $cc_cookie->categories);
//        endif;
//        $scriptattribute = (isset($cc_cookie) && $cc_cookie->analytics) ?: "type='text/plain' data-cookiecategory='analytics'";
//        print "<script " . $scriptattribute . " src='https://unpkg.com/@vimeo/player'></script>";
//        print "<script " . $scriptattribute . " src='" . Path::get('BASE_PATH') . "plugins/vimeo/js/vimeo.js'></script>";
//    endif;
//}

// Template::hooks()->add_action('add_js_action', 'add_vimeo_player');

Hookmanager::add('after_footer', function () {
    if(!in_array("IframeManager", SessionManager::get('plugin_actives'))){
        if (isset($_COOKIE['cc_cookie'])){
            $cc_cookie = json_decode($_COOKIE['cc_cookie']);
            $cc_cookie->necessary = in_array("necessary", $cc_cookie->categories);
            $cc_cookie->analytics = in_array("analytics", $cc_cookie->categories);
            $cc_cookie->targeting = in_array("targeting", $cc_cookie->categories);
        }
        $scriptAttribute = (isset($cc_cookie) && $cc_cookie->analytics) ?: "type='text/plain' data-cookiecategory='analytics'";
        print "<script src='https://unpkg.com/@vimeo/player'></script>";
        print "<script src='" . Path::get('BASE_PATH') . Path::get('PLUGIN_PATH') . "items/collection/vimeo/js/vimeo.js'></script>";
    }
});

RouterManager::instance()->match('GET|POST', '/vimeo/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Vimeo\VimeoController@insert');

RouterManager::instance()->post('/vimeo/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Vimeo\VimeoController@save');
RouterManager::instance()->post('/vimeo/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Vimeo\VimeoController@update');
RouterManager::instance()->post('/vimeo/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Vimeo\VimeoController@delete');