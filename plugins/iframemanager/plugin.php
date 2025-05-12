<?php

use Ivy\Manager\AssetManager;
use Ivy\Path;

AssetManager::addCSS(Path::get('PLUGIN_PATH') . "iframemanager/node_modules/@orestbida/iframemanager/dist/iframemanager.css");
AssetManager::addJS(Path::get('PLUGIN_PATH') . "iframemanager/node_modules/@orestbida/iframemanager/dist/iframemanager.js");
AssetManager::addJS(Path::get('PLUGIN_PATH') . "iframemanager/js/iframemanager-init.js");