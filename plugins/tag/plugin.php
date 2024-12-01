<?php

use Ivy\Template;
use Ivy\User;

Template::addCSS("plugins/tag/css/tag.css");

if (User::isLoggedIn()) {
    if (User::canEditAsEditor()) {
        global $router;
        $router->post('/tag/post', '\Tag\TagController@post');
        $router->get('/plugin/tag', function () {
            $tags = (new \Tag\Tag)->get()->all();
            Template::view(_PLUGIN_PATH . 'tag/template/settings.latte', ['tags' => $tags]);
        });
    }
}