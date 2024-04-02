<?php
defined('_BASE_PATH') or die('Something went wrong');
global $template;

\Ivy\Template::addCSS(_PLUGIN_PATH . "Text/css/text.css");
\Ivy\Template::addJS("node_modules/linkifyjs/dist/linkify.min.js");
\Ivy\Template::addJS("node_modules/linkify-html/dist/linkify-html.min.js");
\Ivy\Template::addJS("plugins/Text/js/text.js");