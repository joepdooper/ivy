<?php

namespace Items\Collection\Article;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Items\ItemRegistry;
use Ivy\Core\Contracts\PluginInterface;
use Ivy\Routing\Route;

class ArticleInterface implements PluginInterface
{
    public function register(): void
    {
        RouterManager::instance()->mount('/article', function () {
            RouterManager::instance()->get('/([a-z0-9_-]+)', '\Items\Collection\Article\ArticleTemplate@page');
            RouterManager::instance()->match('GET|POST', '/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Article\ArticleController@insert');
            RouterManager::instance()->post('/save/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Article\ArticleController@save');
            RouterManager::instance()->post('/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Article\ArticleController@update');
            RouterManager::instance()->post('/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', '\Items\Collection\Article\ArticleController@delete');
        });

        ItemRegistry::register('article', Article::class);
    }

    public function install(): void
    {
        DatabaseManager::connection()->exec('
        CREATE TABLE IF NOT EXISTS `articles` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `item_id` int(11) UNSIGNED NOT NULL,
            `title` VARCHAR(255) NOT NULL,
            `subtitle` VARCHAR(255) NOT NULL,
            `image` VARCHAR(255) DEFAULT NULL,
            `token` INT(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ');
    }

    public function uninstall(): void
    {
        DatabaseManager::connection()->exec(
            '
        DROP TABLE `articles`;
        '
        );

    }
}