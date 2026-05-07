<?php

namespace Items\Collection\Article;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Items\ItemRegistry;
use Ivy\Core\Contracts\PluginInterface;
use Ivy\Routing\Route;

class ArticleInterface implements PluginInterface
{
    public function register(): void
    {
        Route::mount('/article', function () {
            Route::get('/([a-z0-9_-]+)', '\Items\Collection\Article\ArticleTemplate@page');
            Route::get('/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Article\ArticleController@insert');
            Route::post('/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Article\ArticleController@insert');
            Route::post('/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Article\ArticleController@save');
            Route::post('/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Article\ArticleController@update');
            Route::post('/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Article\ArticleController@delete');
        });

        ItemRegistry::register('article', Article::class);
    }

    public function install(): void
    {
        Capsule::schema()->create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('item_id');
            $table->string('title', 255);
            $table->string('subtitle', 255);
            $table->string('image', 255)->nullable();
            $table->integer('token')->nullable();
        });
    }

    public function uninstall(): void
    {
        Capsule::schema()->dropIfExists('articles');
    }
}