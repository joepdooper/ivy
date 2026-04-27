<?php

namespace Items\Collection\Youtube;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Ivy\Core\Contracts\PluginInterface;
use Ivy\Core\Path;
use Ivy\Manager\AssetManager;
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

        RouterManager::instance()->match('GET|POST', '/youtube/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Youtube\YoutubeController@insert');

        RouterManager::instance()->post('/youtube/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Youtube\YoutubeController@save');
        RouterManager::instance()->post('/youtube/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Youtube\YoutubeController@update');
        RouterManager::instance()->post('/youtube/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Youtube\YoutubeController@delete');

        ItemRegistry::register('image', Youtube::class);
    }

    public function install(): void
    {
        DatabaseManager::connection()->exec(
            '
CREATE TABLE `youtubes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `youtube_video_id` varchar(255) DEFAULT NULL,
  `token` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
  '
        );

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

        DatabaseManager::connection()->exec(
            '
    DROP TABLE `youtubes`;
    '
        );
    }
}