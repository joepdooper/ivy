<?php

namespace Search;

use Ivy\Core\Contracts\PluginInterface;
use Ivy\Routing\Route;

class SearchInterface implements PluginInterface
{
    public function register(): void
    {
        Route::mount('/search', function () {
            Route::post('/post', '\Search\SearchController@post')
                ->before('\Ivy\Controller\AdminController@before');
        });
    }

    public function install(): void
    {
        // No database
    }

    public function uninstall(): void
    {
        // No database
    }
}