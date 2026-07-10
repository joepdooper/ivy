<?php

namespace NextcloudApi;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Ivy\Plugin\Application\Contracts\PluginInterface;
use Ivy\Shared\Presentation\Routing\Route;
use Ivy\User\Application\Service\AuthService;

class NextcloudApiInterface implements PluginInterface
{
    public function register(AuthService $auth): void
    {
        Route::mount('/admin/plugin/nextcloudapi', function () {
            Route::get('/index', '\NextcloudApi\NextcloudApiController@index')
                ->before('\Ivy\User\Presentation\Controller\AdminController@before');
            Route::get('/response', '\NextcloudApi\NextcloudApiController@response')
                ->before('\Ivy\User\Presentation\Controller\AdminController@before');
            Route::post('/add', '\NextcloudApi\NextcloudApiController@add')
                ->before('\Ivy\User\Presentation\Controller\AdminController@before');
            Route::post('/delete', '\NextcloudApi\NextcloudApiController@delete')
                ->before('\Ivy\User\Presentation\Controller\AdminController@before');
            Route::post('/update', '\NextcloudApi\NextcloudApiController@update')
                ->before('\Ivy\User\Presentation\Controller\AdminController@before');
        });
    }

    public function install(): void
    {
        Capsule::schema()->create('nextcloud_apis', function (Blueprint $table) {
            $table->increments('id');
            $table->string('protocol', 50);
            $table->string('url', 255);
            $table->integer('port')->nullable();
            $table->string('username', 255)->nullable();
            $table->string('password', 255)->nullable();
            $table->timestamps();
        });
    }

    public function uninstall(): void
    {
        Capsule::schema()->dropIfExists('nextcloud_apis');
    }
}
