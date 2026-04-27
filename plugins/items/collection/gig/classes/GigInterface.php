<?php

namespace Items\Collection\Gig;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Ivy\Core\Contracts\PluginInterface;
use Ivy\Core\Path;
use Ivy\Manager\AssetManager;
use Ivy\Routing\Route;

class GigInterface implements PluginInterface
{
    public function register(): void
    {
        RouterManager::instance()->match('GET|POST', '/gig/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Gig\GigController@insert');

        RouterManager::instance()->post('/gig/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Gig\GigController@save');
        RouterManager::instance()->post('/gig/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Gig\GigController@update');
        RouterManager::instance()->post('/gig/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Gig\GigController@delete');

        ItemRegistry::register('gig', Gig::class);
    }

    public function install(): void
    {
        DatabaseManager::connection()->exec(
            '
  CREATE TABLE `gigs` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `datetime` datetime DEFAULT CURRENT_TIMESTAMP,
    `venue` varchar(255) DEFAULT NULL,
    `address` varchar(255) DEFAULT NULL,
    `latitude` int(11) DEFAULT NULL,
    `longitude` int(11) DEFAULT NULL,
    `price` decimal(8, 2) DEFAULT NULL,
    `url` varchar(255) DEFAULT NULL,
    `subject` int(11) NOT NULL,
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
    DROP TABLE `gigs`;
    '
        );
    }
}