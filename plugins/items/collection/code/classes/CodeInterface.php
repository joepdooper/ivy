<?php

namespace Items\Collection\Code;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Ivy\Core\Contracts\PluginInterface;

class CodeInterface implements PluginInterface
{
    public function register(): void
    {
        AssetManager::addCSS('plugins/items/collection/code/css/code.css');
        AssetManager::addJS('plugins/items/collection/code/js/rainbow.min.js');

        RouterManager::instance()->match('GET|POST', '/code/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Code\CodeController@insert');

        RouterManager::instance()->post('/code/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Code\CodeController@save');
        RouterManager::instance()->post('/code/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Code\CodeController@update');
        RouterManager::instance()->post('/code/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Code\CodeController@delete');

        ItemRegistry::register('code', Code::class);
    }

    public function install(): void
    {
        DatabaseManager::connection()->exec('
CREATE TABLE `codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` TEXT NOT NULL,
  `language` varchar(255) DEFAULT NULL,
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
    DROP TABLE `codes`;
    '
        );
    }
}