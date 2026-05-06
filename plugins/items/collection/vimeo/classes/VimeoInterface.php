<?php

namespace Items\Collection\Vimeo;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Items\ItemRegistry;
use Ivy\Core\Contracts\PluginInterface;
use Ivy\Manager\AssetManager;
use Ivy\Manager\HookManager;
use Ivy\Manager\SecurityManager;
use Ivy\Manager\SessionManager;
use Ivy\Routing\Route;

class VimeoInterface implements PluginInterface
{
    public function register(): void
    {
        HookManager::add('after_footer', function () {
            if (in_array('IframeManager', SessionManager::get('plugin_actives'))) {
                if (isset($_COOKIE['cc_cookie'])) {
                    $cc_cookie = json_decode($_COOKIE['cc_cookie']);
                    $cc_cookie->necessary = in_array('necessary', $cc_cookie->categories);
                    $cc_cookie->analytics = in_array('analytics', $cc_cookie->categories);
                    $cc_cookie->targeting = in_array('targeting', $cc_cookie->categories);
                }
                $scriptAttribute = (isset($cc_cookie) && $cc_cookie->analytics) ?: "type='text/plain' data-cookiecategory='analytics'";
                echo "<script nonce='".SecurityManager::getNonce()."' {$scriptAttribute} src='https://unpkg.com/@vimeo/player'></script>";
                AssetManager::addJS('plugins/items/collection/vimeo/js/vimeo.js');
            } else {
                echo "<script nonce='".SecurityManager::getNonce()."' src='https://unpkg.com/@vimeo/player'></script>";
                AssetManager::addJS('plugins/items/collection/vimeo/js/vimeo.js');
            }
        });

        Route::mount('/vimeo', function () {
            Route::get('/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Vimeo\VimeoController@insert');
            Route::post('/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Vimeo\VimeoController@insert');
            Route::post('/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Vimeo\VimeoController@save');
            Route::post('/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Vimeo\VimeoController@update');
            Route::post('/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Vimeo\VimeoController@delete');
        });

        ItemRegistry::register('vimeo', Vimeo::class);
    }

    public function install(): void
    {
        Capsule::schema()->create('vimeos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vimeo_video_id', 255)->nullable();
            $table->integer('token')->nullable();
        });
    }

    public function uninstall(): void
    {
        Capsule::schema()->dropIfExists('vimeos');
    }
}