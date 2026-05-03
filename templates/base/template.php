<?php

use Ivy\Manager\AssetManager;
use Ivy\Manager\TemplateManager;

AssetManager::addCSS('css/style.css');
AssetManager::addCSS('css/custom.css');
AssetManager::addJS('js/twinspark.min.js');

TemplateManager::require('routes/web.php');
TemplateManager::require('routes/user.php');
TemplateManager::require('routes/admin.php');
TemplateManager::require('routes/error.php');