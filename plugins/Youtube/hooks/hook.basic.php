<?php
defined('_BASE_PATH') or die('Something went wrong');

\Ivy\Template::addCSS("plugins/Youtube/css/youtube.css");
if (!in_array("IframeManager", $_SESSION['plugin_actives'])):
    \Ivy\Template::addJS("plugins/Youtube/js/youtube.js");
endif;
