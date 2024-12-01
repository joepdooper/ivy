<?php

use Ivy\Template;

Template::addCSS('node_modules/normalize.css/normalize.css');
Template::addCSS('css/output.css');
// Template::addCSS('css/swup.css');
Template::addCSS('css/style_sub.css');

Template::addJS('node_modules/axios/dist/axios.min.js');
Template::addJS('node_modules/petite-vue/dist/petite-vue.umd.js');
Template::addJS('templates/base/js/template.js');