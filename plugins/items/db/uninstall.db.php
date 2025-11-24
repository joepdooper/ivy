<?php

use Ivy\Manager\DatabaseManager;
use Ivy\Model\User;
use Ivy\Core\Path;

if(User::canEditAsSuperAdmin()) {
    try {
        DatabaseManager::connection()->exec(
            'DROP TABLE `items`;'
        );
    } catch (Exception $e) {
        error_log("Failed to drop table `items`: " . $e->getMessage());
    }

    $mediaPath = Path::get('MEDIA_PATH') . 'items';
    if (is_dir($mediaPath)) {
        $files = glob($mediaPath . '/*');
        $files = array_merge($files ?: [], glob($mediaPath . '/.*') ?: []);
        foreach ($files as $file) {
            if (is_file($file) && basename($file) !== '.' && basename($file) !== '..') {
                unlink($file);
            }
        }
        rmdir($mediaPath);
    }
}