<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Ivy\Model\User;

if (User::canEditAsSuperAdmin()) {

    try {
        if (!Capsule::schema()->hasTable('tags')) {
            Capsule::schema()->create('tags', function (Blueprint $table) {
                $table->increments('id');
                $table->string('value', 255);
            });
        }
    } catch (\Throwable $e) {
        error_log('Failed to create table `tags`: ' . $e->getMessage());
    }

    try {
        if (!Capsule::schema()->hasTable('entity_tags')) {
            Capsule::schema()->create('entity_tags', function (Blueprint $table) {
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
        }
    } catch (\Throwable $e) {
        error_log('Failed to create table `entity_tags`: ' . $e->getMessage());
    }
}