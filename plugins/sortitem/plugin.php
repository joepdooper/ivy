<?php

use Ivy\Core\Path;
use Ivy\Manager\AssetManager;

AssetManager::addCSS('plugins/sortitem/css/sort.css');
AssetManager::addJS('node_modules/sortablejs/sortable.min.js');
AssetManager::addJS(Path::get('PLUGINS_PATH').'sortitem/js/sortitem.js');

include 'routes/routes.php';
