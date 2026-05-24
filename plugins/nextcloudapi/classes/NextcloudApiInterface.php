<?php

namespace NextcloudApi;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Ivy\Plugin\Application\Contracts\PluginInterface;
use Ivy\Shared\Presentation\Routing\Route;
use Ivy\User\Domain\Entity\Profile;

class NextcloudApiInterface implements PluginInterface
{
    public function register(): void
    {
        Route::mount('/admin/plugin/nextcloudapi', function () {
            Route::get('/servers', '\NextcloudApi\NextcloudApiController@servers')
                ->before('\Ivy\User\Presentation\Controller\AdminController@before');
            Route::get('/server/(\d+)/status', '\NextcloudApi\NextcloudApiController@status')
                ->before('\Ivy\User\Presentation\Controller\AdminController@before');
            Route::post('/sync', '\NextcloudApi\NextcloudApiController@sync')
                ->before('\Ivy\User\Presentation\Controller\AdminController@before');
        });

        Profile::created(function (Profile $profile) {
            d('Created user id: ' . $profile->user->id);die;
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
        });
    }

    public function uninstall(): void
    {
        Capsule::schema()->dropIfExists('nextcloud_apis');
    }
}