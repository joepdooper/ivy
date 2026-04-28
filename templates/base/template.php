<?php

use Ivy\Manager\AssetManager;
use Ivy\Manager\TemplateManager;

AssetManager::addCSS('css/style.css');
AssetManager::addCSS('css/custom.css');
AssetManager::addJS('js/twinspark.min.js');

require TemplateManager::file('routes/web.php');
require TemplateManager::file('routes/user.php');
require TemplateManager::file('routes/admin.php');
require TemplateManager::file('routes/error.php');
