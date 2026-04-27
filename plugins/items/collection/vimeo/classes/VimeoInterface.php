<?php

namespace Items\Collection\Vimeo;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Items\ItemRegistry;
use Ivy\Core\Contracts\PluginInterface;
use Ivy\Manager\AssetManager;
use Ivy\Manager\HookManager;

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

        RouterManager::instance()->match('GET|POST', '/vimeo/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Vimeo\VimeoController@insert');

        RouterManager::instance()->post('/vimeo/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Vimeo\VimeoController@save');
        RouterManager::instance()->post('/vimeo/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Vimeo\VimeoController@update');
        RouterManager::instance()->post('/vimeo/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Vimeo\VimeoController@delete');

        ItemRegistry::register('image', Vimeo::class);
    }

    public function install(): void
    {
        DatabaseManager::connection()->exec(
            '
    CREATE TABLE `vimeos` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `vimeo_video_id` varchar(255) DEFAULT NULL,
      `token` int(11) DEFAULT NULL,
      PRIMARY KEY (`id`)
      ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
      '
        );
    }

    public function uninstall(): void
    {
        DatabaseManager::connection()->exec(
            '
        DROP TABLE `vimeos`;
        '
        );
    }
}