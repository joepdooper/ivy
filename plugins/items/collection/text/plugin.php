<?php

use Ivy\Template;
use Ivy\User;
use Text\EditorTextController;

Template::addCSS(_PLUGIN_PATH . "text/css/text.css");
Template::addJS("node_modules/linkifyjs/dist/linkify.min.js");
Template::addJS("node_modules/linkify-html/dist/linkify-html.min.js");
Template::addJS(_PLUGIN_PATH . "text/js/text.js");

if (User::isLoggedIn()) {
    if (User::canEditAsEditor()) {

        Template::hooks()->add_action('after_body_action', function () {
            Template::render(_PLUGIN_PATH . 'text/template/toolbar.latte');
        });

        Template::hooks()->add_action('add_js_action', function () {
            print "<script src='" . _BASE_PATH . _PLUGIN_PATH . "text/js/text_admin.js'></script>";
        });

    }
}

if (User::isLoggedIn()) {
    if (User::canEditAsEditor()) {
        global $router;

        $router->match('GET|POST', '/text/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', function ($id, $template_route = null, $identifier = null) {
            (new EditorTextController)->insert($id, $template_route, $identifier);
        });

        $router->match('GET|POST', '/text/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', function ($id, $template_route = null, $identifier = null) {
            (new EditorTextController)->update($id, $template_route, $identifier);
        });

        $router->match('GET|POST', '/text/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', function ($id, $template_route = null, $identifier = null) {
            (new EditorTextController)->delete($id, $template_route, $identifier);
        });
    }
}