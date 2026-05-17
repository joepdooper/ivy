<?php

namespace NextcloudApi;

use Ivy\Plugin\Application\Contracts\PluginInterface;
use Ivy\Shared\Presentation\Routing\Route;

class NextcloudApiInterface implements PluginInterface
{
    public function register(): void
    {
        Route::mount('/admin/plugin/nextcloud-api', function () {
            Route::get('/manage', '\NextcloudApi\NextcloudApiController@index')
                ->before('\Ivy\User\Presentation\Controller\AdminController@before');
            Route::post('/sync', '\NextcloudApi\NextcloudApiController@sync')
                ->before('\Ivy\User\Presentation\Controller\AdminController@before');
        });
    }

    public function install(): void
    {
    }

    public function uninstall(): void
    {
    }
}