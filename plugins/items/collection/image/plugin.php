<?php

use Ivy\Manager\AssetManager;
use Ivy\Manager\RouterManager;
use Ivy\Model\User;
use Ivy\Core\Path;

AssetManager::addCSS(Path::get('PLUGINS_PATH') . "items/collection/image/css/image.css");

if (User::canEditAsEditor()) {
    AssetManager::addJS(Path::get('PLUGINS_PATH') . "items/collection/image/js/image_admin.js");
}

//if (User::getAuth()->isLoggedIn()) {
//    if (User::canEditAsEditor()) {
//
//        $router->get('/plugin/image', function () {
//            $image_sizes = (new \Image\ImageSize)->get()->all();
//            Template::view(_PLUGINS_PATH . 'image/template/image_sizes.latte', ['image_sizes' => $image_sizes]);
//        });
//
//        $router->post('/image_sizes/post', '\Image\SettingController@post');
//    }
//}

RouterManager::instance()->match('GET|POST', '/image/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Image\ImageController@insert');

RouterManager::instance()->post('/image/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Image\ImageController@save');
RouterManager::instance()->post('/image/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Image\ImageController@update');
RouterManager::instance()->post('/image/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Image\ImageController@delete');

RouterManager::instance()->post('/image/sizes/post', '\Items\Collection\Image\ImageController@post');
RouterManager::instance()->post('/image/sizes/index', '\Items\Collection\Image\ImageController@index');
