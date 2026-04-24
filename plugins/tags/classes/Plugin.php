<?php

namespace Tags;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Blueprint;
use Ivy\Core\Contracts\PluginInterface;
use Ivy\Manager\AssetManager;
use Ivy\Routing\Route;

class Plugin implements PluginInterface
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

    public function boot(): void {}
}