<?php

use Ivy\Manager\AssetManager;
use Ivy\Core\Path;

// AssetManager::addViteEntry(Path::get('PLUGINS_PATH') . "vanillacookieconsent/js/cookieconsent-config.js");
AssetManager::addViteEntry(Path::get('PLUGINS_PATH') . "vanillacookieconsent/node_modules/vanilla-cookieconsent/dist/cookieconsent.esm.js");
AssetManager::addCSS("plugins/vanillacookieconsent/node_modules/vanilla-cookieconsent/dist/cookieconsent.css");
