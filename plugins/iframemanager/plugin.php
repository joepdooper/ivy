<?php

use Ivy\Manager\AssetManager;
use Ivy\Core\Path;

AssetManager::addCSS("plugins/iframemanager/node_modules/@orestbida/iframemanager/dist/iframemanager.css");
AssetManager::addJS(Path::get('PLUGINS_PATH') . "iframemanager/node_modules/@orestbida/iframemanager/dist/iframemanager.js");
AssetManager::addJS(Path::get('PLUGINS_PATH') . "iframemanager/js/iframemanager-init.js");