<?php

namespace Items\Collection\Audio;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Ivy\Core\Contracts\PluginInterface;

class AudioInterface implements PluginInterface
{
    public function register(): void
    {
        AssetManager::addCSS('plugins/items/collection/audio/css/audio.css');

        if (User::canEditAsEditor()) {
            AssetManager::addJS('plugins/items/collection/audio/js/audio_admin.js');
        }

        RouterManager::instance()->mount('/audio', function () {
            RouterManager::instance()->match('GET|POST', '/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Audio\AudioController@insert');
            RouterManager::instance()->post('/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Audio\AudioController@save');
            RouterManager::instance()->post('/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Audio\AudioController@update');
            RouterManager::instance()->post('/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Audio\AudioController@delete');
        });

        ItemRegistry::register('audio', Audio::class);
    }

    public function install(): void
    {
        DatabaseManager::connection()->exec(
            '
CREATE TABLE `audios` (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `item_id` int(11) UNSIGNED NOT NULL,
    `file` varchar(255) DEFAULT NULL,
    `token` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`item_id`) REFERENCES `items`(`id`) ON DELETE CASCADE
  ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
  '
        );
    }

    public function uninstall(): void
    {
        DatabaseManager::connection()->exec(
            '
    DROP TABLE `audios`;
    '
        );
    }
}