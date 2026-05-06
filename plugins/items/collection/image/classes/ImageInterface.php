<?php

namespace Items\Collection\Image;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Ivy\Core\Contracts\PluginInterface;
use Ivy\Core\Path;
use Ivy\Manager\AssetManager;
use Ivy\Routing\Route;

class ImageInterface implements PluginInterface
{
    public function register(): void
    {
        AssetManager::addCSS('plugins/items/collection/image/css/image.css');

        if (User::canEditAsEditor()) {
            AssetManager::addJS('plugins/items/collection/image/js/image.admin.js');
        }

// if (User::getAuth()->isLoggedIn()) {
//    if (User::canEditAsEditor()) {
//
//        $router->get('/plugin/image', function () {
//            $image_sizes = (new \Image\ImageSize)->get()->all();
//            Template::view(_PLUGINS_PATH . 'image/template/image_sizes.latte', ['image_sizes' => $image_sizes]);
//        });
//
//        $router->post('/image_sizes/post', '\Image\SettingController@post');
//    }
// }

        RouterManager::instance()->match('GET|POST', '/image/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Image\ImageController@insert');

        RouterManager::instance()->post('/image/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Image\ImageController@save');
        RouterManager::instance()->post('/image/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Image\ImageController@update');
        RouterManager::instance()->post('/image/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Image\ImageController@delete');

        RouterManager::instance()->post('/image/sizes/post', '\Items\Collection\Image\ImageController@post');
        RouterManager::instance()->post('/image/sizes/index', '\Items\Collection\Image\ImageController@index');

        ItemRegistry::register('image', Image::class);
    }

    public function install(): void
    {
        DatabaseManager::connection()->exec(
            'CREATE TABLE `images` (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `item_id` int(11) UNSIGNED NOT NULL,
    `file` varchar(255) DEFAULT NULL,
    `token` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`item_id`) REFERENCES `items`(`id`) ON DELETE CASCADE
  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;'
        );

        DatabaseManager::connection()->exec(
            '
CREATE TABLE `image_sizes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255),
  `bool` tinyint(1) DEFAULT 0,
  `value` int(11) DEFAULT NULL,
  `info` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
  '
        );
    }

    public function uninstall(): void
    {
        DatabaseManager::connection()->exec(
            '
        DROP TABLE `images`;
        '
        );

        DatabaseManager::connection()->exec(
            '
        DROP TABLE `image_sizes`;
        '
        );
    }
}