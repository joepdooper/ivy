<?php

namespace NextcloudApi;

use Ivy\Plugin\Application\Contracts\PluginInterface;
use Ivy\Shared\Presentation\Routing\Route;
use Ivy\User\Domain\Entity\Profile;
use Ivy\User\Domain\Entity\User;

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

        Profile::created(function (Profile $user) {
            d('Created profile: ' . $user->id);die;
        });

        Profile::saved(function (Profile $user) {
            d('Saved user: ' . $user->id);die;
        });

        Profile::deleted(function (Profile $user) {
            d('Deleted user: ' . $user->id);die;
        });
    }

    public function install(): void
    {
    }

    public function uninstall(): void
    {
    }
}