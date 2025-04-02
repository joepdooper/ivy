<?php

use Ivy\Template;

AssetManager::addCSS(_PLUGIN_PATH . "code/css/code.css");
AssetManager::addJS(_PLUGIN_PATH . "code/js/rainbow.min.js");

include 'routes/routes.php';