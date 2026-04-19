<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Ivy\Model\User;

if (User::canEditAsSuperAdmin()) {

    try {
        Capsule::schema()->dropIfExists('entity_tags');
    } catch (\Throwable $e) {
        error_log('Failed to drop table `entity_tags`: ' . $e->getMessage());
    }

    try {
        Capsule::schema()->dropIfExists('tags');
    } catch (\Throwable $e) {
        error_log('Failed to drop table `tags`: ' . $e->getMessage());
    }

}