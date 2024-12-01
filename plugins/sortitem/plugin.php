<?php

use Ivy\Template;

Template::addCSS(_PLUGIN_PATH . "sortitem/css/sort.css");
Template::addJS("node_modules/sortablejs/sortable.min.js");
Template::addJS(_PLUGIN_PATH . "sortitem/js/sortitem.js");

include 'routes/routes.php';