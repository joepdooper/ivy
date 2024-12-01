<?php

use Ivy\Template;

Template::addCSS(_PLUGIN_PATH . "code/css/code.css");
Template::addJS(_PLUGIN_PATH . "code/js/rainbow.min.js");

include 'routes/routes.php';