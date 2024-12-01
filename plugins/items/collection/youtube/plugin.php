<?php

use Ivy\Template;

Template::addCSS("plugins/youtube/css/youtube.css");
if (!in_array("IframeManager", $_SESSION['plugin_actives'])):
    Template::addJS("plugins/youtube/js/youtube.js");
endif;

include 'routes/routes.php';