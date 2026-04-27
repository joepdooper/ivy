<?php

namespace Items\Collection\Documentation;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Ivy\Core\Contracts\PluginInterface;
use Ivy\Core\Path;
use Ivy\Manager\AssetManager;
use Ivy\Routing\Route;

class DocumentationInterface implements PluginInterface
{
    public function register(): void
    {
        RouterManager::instance()->get('/documentation/([a-z0-9_-]+)', '\Items\Collection\Documentation\DocumentationTemplate@page');

        RouterManager::instance()->match('GET|POST', '/documentation/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Documentation\DocumentationController@insert');

        RouterManager::instance()->post('/documentation/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Documentation\DocumentationController@save');
        RouterManager::instance()->post('/documentation/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Documentation\DocumentationController@update');
        RouterManager::instance()->post('/documentation/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Documentation\DocumentationController@delete');

        ItemRegistry::register('documentation', Documentation::class);
    }

    public function install(): void
    {
        DatabaseManager::connection()->exec(
            '
CREATE TABLE `documentations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `subject` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
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
    DROP TABLE `documentations`;
    '
        );
    }
}