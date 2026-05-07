<?php

namespace Items\Collection\Image;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Items\ItemRegistry;
use Ivy\Core\Contracts\PluginInterface;
use Ivy\Manager\AssetManager;
use Ivy\Model\User;
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

        Route::mount('/image', function () {
            Route::get('/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Image\ImageController@insert');
            Route::post('/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Image\ImageController@insert');
            Route::post('/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Image\ImageController@save');
            Route::post('/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Image\ImageController@update');
            Route::post('/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Image\ImageController@delete');
            Route::post('/sizes/post', '\Items\Collection\Image\ImageController@post');
            Route::post('/sizes/index', '\Items\Collection\Image\ImageController@index');
        });

        ItemRegistry::register('image', Image::class);
    }

    public function install(): void
    {
        Capsule::schema()->create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('item_id');
            $table->string('file', 255)->nullable();
            $table->integer('token')->nullable();
        });

        Capsule::schema()->create('image_sizes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->nullable();
            $table->boolean('bool')->default(false);
            $table->integer('value')->nullable();
            $table->string('info', 255)->nullable();
        });
    }

    public function uninstall(): void
    {
        Capsule::schema()->dropIfExists('images');
        Capsule::schema()->dropIfExists('image_sizes');
    }
}