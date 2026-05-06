<?php

namespace Items\Collection\Gig;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Items\ItemRegistry;
use Ivy\Core\Contracts\PluginInterface;
use Ivy\Routing\Route;

class GigInterface implements PluginInterface
{
    public function register(): void
    {
        Route::mount('/gig', function () {
            Route::get('/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Gig\GigController@insert');
            Route::post('/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Gig\GigController@insert');
            Route::post('/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Gig\GigController@save');
            Route::post('/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Gig\GigController@update');
            Route::post('/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Gig\GigController@delete');
        });

        ItemRegistry::register('gig', Gig::class);
    }

    public function install(): void
    {
        Capsule::schema()->create('gigs', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('datetime')->useCurrent();
            $table->string('venue', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->integer('latitude')->nullable();
            $table->integer('longitude')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->string('url', 255)->nullable();
            $table->integer('subject');
            $table->integer('token')->nullable();
        });
    }

    public function uninstall(): void
    {
        Capsule::schema()->dropIfExists('gigs');
    }
}