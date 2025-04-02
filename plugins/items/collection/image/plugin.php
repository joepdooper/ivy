<?php

use Image\EditorImageController;
use Ivy\Template;
use Ivy\User;

AssetManager::addCSS(_PLUGIN_PATH . "image/css/image.css");

if (User::getAuth()->isLoggedIn()) {
    if (User::canEditAsEditor()) {
        AssetManager::addJS("plugins/image/js/image_admin.js");
    }
}

if (User::getAuth()->isLoggedIn()) {
    if (User::canEditAsEditor()) {
        global $router;

        $router->match('GET|POST', '/image/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', function ($id, $template_route = null, $identifier = null) {
            (new EditorImageController)->insert($id, $template_route, $identifier);
        });

        $router->match('GET|POST', '/image/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', function ($id, $template_route = null, $identifier = null) {
            (new EditorImageController)->update($id, $template_route, $identifier);
        });

        $router->match('GET|POST', '/image/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', function ($id, $template_route = null, $identifier = null) {
            (new EditorImageController)->delete($id, $template_route, $identifier);
        });

        $router->get('/plugin/image', function () {
            $image_sizes = (new \Image\ImageSize)->get()->all();
            Template::view(_PLUGIN_PATH . 'image/template/image_sizes.latte', ['image_sizes' => $image_sizes]);
        });

        $router->post('/image_sizes/post', '\Image\SettingController@post');
    }
}