<?php

namespace Items\Collection\Audio;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Items\ItemRegistry;
use Ivy\Core\Contracts\PluginInterface;
use Ivy\Manager\AssetManager;
use Ivy\Routing\Route;
use Ivy\Model\User;

class AudioInterface implements PluginInterface
{
    public function register(): void
    {
        AssetManager::addCSS('plugins/items/collection/audio/css/audio.css');

        if (User::canEditAsEditor()) {
            AssetManager::addJS('plugins/items/collection/audio/js/audio_admin.js');
        }

        Route::mount('/audio', function () {
            Route::get('/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Audio\AudioController@insert');
            Route::post('/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Audio\AudioController@insert');
            Route::post('/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Audio\AudioController@save');
            Route::post('/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Audio\AudioController@update');
            Route::post('/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Audio\AudioController@delete');
        });

        ItemRegistry::register('audio', Audio::class);
    }

    public function install(): void
    {
        Capsule::schema()->create('audios', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('item_id');
            $table->string('file', 255)->nullable();
            $table->integer('token')->nullable();
        });
    }

    public function uninstall(): void
    {
        Capsule::schema()->dropIfExists('audios');
    }
}