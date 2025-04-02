<?php

use Audio\EditorAudioController;
use Ivy\User;

AssetManager::addCSS("plugins/audio/css/audio.css");

function add_audio_admin_js(): void
{
    print "<script src='" . Path::get('BASE_PATH') . _PLUGIN_PATH . "audio/js/audio_admin.js'></script>";
}

Template::hooks()->add_action('add_js_action', 'add_audio_admin_js');

if (User::getAuth()->isLoggedIn()) {
    if (User::canEditAsEditor()) {
        global $router;

        $router->match('GET|POST', '/audio/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', function ($id, $template_route = null, $identifier = null) {
            (new EditorAudioController)->insert($id, $template_route, $identifier);
        });

        $router->match('GET|POST', '/audio/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', function ($id, $template_route = null, $identifier = null) {
            (new EditorAudioController)->update($id, $template_route, $identifier);
        });

        $router->match('GET|POST', '/audio/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', function ($id, $template_route = null, $identifier = null) {
            (new EditorAudioController)->delete($id, $template_route, $identifier);
        });
    }
}