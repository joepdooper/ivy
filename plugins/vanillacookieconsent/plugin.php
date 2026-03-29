<?php

use Ivy\Core\Path;
use Ivy\Manager\AssetManager;

// AssetManager::addJS(Path::get('PLUGINS_PATH') . "vanillacookieconsent/js/cookieconsent-config.js");
AssetManager::addJS(Path::get('PLUGINS_PATH').'vanillacookieconsent/node_modules/vanilla-cookieconsent/dist/cookieconsent.esm.js');
AssetManager::addCSS('plugins/vanillacookieconsent/node_modules/vanilla-cookieconsent/dist/cookieconsent.css');
