<?php

use Ivy\Core\Path;
use Ivy\Manager\AssetManager;

AssetManager::addCSS('plugins/iframemanager/node_modules/@orestbida/iframemanager/dist/iframemanager.css');
AssetManager::addJS(Path::get('PLUGINS_PATH').'iframemanager/node_modules/@orestbida/iframemanager/dist/iframemanager.js');
AssetManager::addJS(Path::get('PLUGINS_PATH').'iframemanager/js/iframemanager-init.js');
