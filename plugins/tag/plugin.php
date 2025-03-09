<?php

use Ivy\App;
use Ivy\Path;
use Ivy\Template;
use Ivy\User;

Template::addCSS("plugins/tag/css/tag.css");

if (User::getAuth()->isLoggedIn()) {
    if (User::canEditAsEditor()) {
        App::router()->post('/tag/post', '\Tag\TagController@post');
        App::router()->get('/plugin/tag/manage', function () {
            $tags = (new \Tag\Tag)->fetchAll();
            Template::view(Path::get('PLUGIN_PATH') . 'tag/template/manage.latte', ['tags' => $tags]);
        });
    }
}