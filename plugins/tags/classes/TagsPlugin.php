<?php

namespace Tags;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Blueprint;
use Ivy\Core\Contracts\PluginInterface;
use Ivy\Manager\AssetManager;
use Ivy\Routing\Route;

class TagsPlugin implements PluginInterface
{
    public function register(): void
    {
        AssetManager::addCSS('plugins/tags/css/tag.css');

        Route::mount('/admin/plugin/tags', function () {
            Route::get('/manage', '\Tags\TagController@index')
                ->before('\Ivy\Controller\AdminController@before');
            Route::post('/sync', '\Tags\TagController@sync')
                ->before('\Ivy\Controller\AdminController@before');
        });
    }

    public function install(): void
    {
        try {
            Manager::schema()->create('tags', function (Blueprint $table) {
                $table->increments('id');
                $table->string('value', 255);
            });
        } catch (\Throwable $e) {
            error_log('tags install failed: ' . $e->getMessage());
        }

        try {
            Manager::schema()->create('entity_tags', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('tag_id');
                $table->string('entity_table', 255);
                $table->unsignedInteger('entity_id');

                $table->unique(['tag_id', 'entity_table', 'entity_id'], 'unique_tag_entity');

                $table->foreign('tag_id')
                    ->references('id')
                    ->on('tags')
                    ->onDelete('cascade');
            });
        } catch (\Throwable $e) {
            error_log('entity_tags install failed: ' . $e->getMessage());
        }
    }

    public function uninstall(): void
    {
        try {
            Manager::schema()->dropIfExists('entity_tags');
            Manager::schema()->dropIfExists('tags');
        } catch (\Throwable $e) {
            error_log('tags uninstall failed: ' . $e->getMessage());
        }
    }
}