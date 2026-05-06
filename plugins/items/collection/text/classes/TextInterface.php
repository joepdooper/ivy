<?php

namespace Items\Collection\Text;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Items\ItemRegistry;
use Ivy\Core\Contracts\PluginInterface;
use Ivy\Manager\AssetManager;
use Ivy\Manager\HookManager;
use Ivy\Model\User;
use Ivy\Routing\Route;
use Ivy\View\View;

class TextInterface implements PluginInterface
{
    public function register(): void
    {
        AssetManager::addCSS('plugins/items/collection/text/css/text.css');
        AssetManager::addJS('plugins/items/collection/text/js/text.js');

        if (User::canEditAsEditor()) {
            AssetManager::addJS('plugins/items/collection/text/js/text_admin.js');
            HookManager::add('before_footer', function () {
                View::render('plugins/items/collection/text/template/toolbar.latte');
            });
        }

        Route::mount('/text', function () {
            Route::get('/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Text\TextController@insert');
            Route::post('/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Text\TextController@insert');
            Route::post('/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Text\TextController@save');
            Route::post('/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Text\TextController@update');
            Route::post('/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Text\TextController@delete');
        });

        ItemRegistry::register('text', Text::class);
    }

    public function install(): void
    {
        Capsule::schema()->create('texts', function (Blueprint $table) {
            $table->increments('id');
            $table->text('text');
            $table->integer('token')->nullable();
        });
    }

    public function uninstall(): void
    {
        Capsule::schema()->dropIfExists('texts');
    }
}