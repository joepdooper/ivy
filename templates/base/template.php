<?php

use Ivy\Handler\MinifyCssHandler;
use Ivy\Handler\MinifyJsHandler;
use Ivy\Manager\AssetManager;
use Ivy\Manager\TemplateManager;
use Ivy\Registry\SettingRegistry;

AssetManager::addCSS('css/style.css');
AssetManager::addCSS('css/custom.css');
AssetManager::addJS('js/twinspark.min.js');

TemplateManager::require('routes/web.php');
TemplateManager::require('routes/user.php');
TemplateManager::require('routes/admin.php');
TemplateManager::require('routes/error.php');

SettingRegistry::define('Minify CSS', [
    'handler' => MinifyCssHandler::class,
]);

SettingRegistry::define('Minify JS', [
    'handler' => MinifyJsHandler::class,
]);
