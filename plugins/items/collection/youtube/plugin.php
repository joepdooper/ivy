<?php

use Ivy\Template;

AssetManager::addCSS("plugins/youtube/css/youtube.css");
if (!in_array("IframeManager", $_SESSION['plugin_actives'])):
    AssetManager::addJS("plugins/youtube/js/youtube.js");
endif;

include 'routes/routes.php';