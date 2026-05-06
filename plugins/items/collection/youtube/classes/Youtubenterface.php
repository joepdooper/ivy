<?php

namespace Items\Collection\Youtube;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Items\ItemRegistry;
use Ivy\Core\Contracts\PluginInterface;
use Ivy\Manager\AssetManager;
use Ivy\Manager\HookManager;
use Ivy\Manager\SecurityManager;
use Ivy\Manager\SessionManager;
use Ivy\Routing\Route;

class YoutubeInterface implements PluginInterface
{
    public function register(): void
    {
        AssetManager::addCSS('plugins/items/collection/youtube/css/youtube.css');

        HookManager::add('after_footer', function () {
            if (in_array('IframeManager', SessionManager::get('plugin_actives'))) {
                if (isset($_COOKIE['cc_cookie'])) {
                    $cc_cookie = json_decode($_COOKIE['cc_cookie']);
                    $cc_cookie->necessary = in_array('necessary', $cc_cookie->categories);
                    $cc_cookie->analytics = in_array('analytics', $cc_cookie->categories);
                    $cc_cookie->targeting = in_array('targeting', $cc_cookie->categories);
                }
                $scriptAttribute = (isset($cc_cookie) && $cc_cookie->analytics) ?: "type='text/plain' data-cookiecategory='analytics'";
                echo "<script nonce='".SecurityManager::getNonce()."' {$scriptAttribute} src='https://www.youtube.com/player_api'></script>";
                AssetManager::addJS('plugins/items/collection/youtube/js/youtube.js');
            } else {
                echo "<script nonce='".SecurityManager::getNonce()."' src='https://www.youtube.com/player_api'></script>";
                AssetManager::addJS('plugins/items/collection/youtube/js/youtube.js');
            }
        });

        Route::mount('/youtube', function () {
            Route::get('/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Youtube\YoutubeController@insert');
            Route::post('/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Youtube\YoutubeController@insert');
            Route::post('/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Youtube\YoutubeController@save');
            Route::post('/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Youtube\YoutubeController@update');
            Route::post('/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Youtube\YoutubeController@delete');
        });

        ItemRegistry::register('youtube', Youtube::class);
    }

    public function install(): void
    {
        Capsule::schema()->create('youtubes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('youtube_video_id', 255)->nullable();
            $table->integer('token')->nullable();
        });

        Capsule::table('item_templates')->insert([
            'name'        => 'Youtube',
            'table'       => 'youtube',
            'plugin_url'  => 'items/collection/youtube',
            'route'       => 'youtube',
            'namespace'   => 'Items\\Collection\\Youtube',
        ]);
    }

    public function uninstall(): void
    {
        Capsule::table('item_templates')
            ->where('plugin_url', 'youtube')
            ->delete();

        Capsule::schema()->dropIfExists('youtubes');
    }
}