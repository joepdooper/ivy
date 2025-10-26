<?php

use Ivy\Manager\AssetManager;
use Ivy\Core\Path;

AssetManager::addCSS("plugins/sortitem/css/sort.css");
AssetManager::addJS("node_modules/sortablejs/sortable.min.js");
AssetManager::addJS(Path::get('PLUGINS_PATH') . "sortitem/js/sortitem.js");

include 'routes/routes.php';