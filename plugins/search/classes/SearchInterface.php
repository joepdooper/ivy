<?php

namespace Search;

use Ivy\Plugin\Application\Contracts\PluginInterface;

class SearchInterface implements PluginInterface
{
    public function register(): void
    {
        //        Route::mount('/search', function () {
        //            Route::post('/post', '\Search\SearchController@post')
        //                ->before('\Ivy\Controller\AdminController@before');
        //        });
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
