<?php

namespace Items\Collection\Code;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Items\ItemRegistry;
use Ivy\Core\Contracts\PluginInterface;
use Ivy\Manager\AssetManager;
use Ivy\Routing\Route;

class CodeInterface implements PluginInterface
{
    public function register(): void
    {
        AssetManager::addCSS('plugins/items/collection/code/css/code.css');
        AssetManager::addJS('plugins/items/collection/code/js/rainbow.min.js');

        Route::mount('/code', function () {
            Route::get('/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Code\CodeController@insert');
            Route::post('/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Code\CodeController@insert');
            Route::post('/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Code\CodeController@save');
            Route::post('/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Code\CodeController@update');
            Route::post('/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Code\CodeController@delete');
        });

        ItemRegistry::register('code', Code::class);
    }

    public function install(): void
    {
        Capsule::schema()->create('codes', function (Blueprint $table) {
            $table->increments('id');
            $table->text('code');
            $table->string('language', 255)->nullable();
            $table->integer('token')->nullable();
        });
    }

    public function uninstall(): void
    {
        Capsule::schema()->dropIfExists('codes');
    }
}