<?php

namespace Items\Collection\Text;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Ivy\Core\Contracts\PluginInterface;

class TextInterface implements PluginInterface
{
    public function register(): void
    {
        AssetManager::addCSS('plugins/items/collection/text/css/text.css');
        AssetManager::addJS('plugins/items/collection/text/js/text.js');

        if (User::canEditAsEditor()) {
            AssetManager::addJS('plugins/items/collection/text/js/text_admin.js');
            HookManager::add('before_footer', function () {
                View::render('plugins/items/collection/text/template/toolbar.latte');
            });
        }

        RouterManager::instance()->match('GET|POST', '/text/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Text\TextController@insert');

        RouterManager::instance()->post('/text/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Text\TextController@save');
        RouterManager::instance()->post('/text/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Text\TextController@update');
        RouterManager::instance()->post('/text/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Text\TextController@delete');

        ItemRegistry::register('text', Text::class);
    }

    public function install(): void
    {
        DatabaseManager::connection()->exec(
            '
CREATE TABLE `texts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` TEXT NOT NULL,
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
        DROP TABLE `texts`;
        '
        );
    }
}