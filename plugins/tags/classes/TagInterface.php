<?php

namespace Tags;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Ivy\Core\Contracts\PluginInterface;
use Ivy\Manager\AssetManager;
use Ivy\Routing\Route;

class TagInterface implements PluginInterface
{
    public function register(): void
    {
        AssetManager::addCSS('plugins/tags/css/tag.css');

        Route::mount('/admin/plugin/tags', function () {
            Route::get('/manage', '\Tags\TagController@index')
                ->before('\Ivy\Controller\AdminController@before');
            Route::post('/sync', '\Tags\TagController@sync')
                ->before('\Ivy\Controller\AdminController@before');
        });
    }

    public function install(): void
    {
        Capsule::schema()->create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('value', 255);
        });
        Capsule::schema()->create('entity_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tag_id');
            $table->string('entity_table', 255);
            $table->unsignedInteger('entity_id');
        });
    }

    public function uninstall(): void
    {
        Capsule::schema()->dropIfExists('entity_tags');
        Capsule::schema()->dropIfExists('tags');
    }
}