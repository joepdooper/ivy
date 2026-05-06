<?php

namespace Items\Collection\Documentation;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Items\ItemRegistry;
use Ivy\Core\Contracts\PluginInterface;
use Ivy\Routing\Route;

class DocumentationInterface implements PluginInterface
{
    public function register(): void
    {
        Route::mount('/documentation', function () {
            Route::get('/([a-z0-9_-]+)', '\Items\Collection\Documentation\DocumentationTemplate@page');
            Route::get('/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Documentation\DocumentationController@insert');
            Route::post('/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Documentation\DocumentationController@insert');
            Route::post('/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Documentation\DocumentationController@save');
            Route::post('/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Documentation\DocumentationController@update');
            Route::post('/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Documentation\DocumentationController@delete');
        });

        ItemRegistry::register('documentation', Documentation::class);
    }

    public function install(): void
    {
        Capsule::schema()->create('documentations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255);
            $table->string('subtitle', 255)->nullable();
            $table->integer('subject');
            $table->integer('item_id')->nullable();
            $table->integer('token')->nullable();
        });
    }

    public function uninstall(): void
    {
        Capsule::schema()->dropIfExists('documentations');
    }
}