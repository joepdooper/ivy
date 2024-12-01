<?php

use Ivy\User;
use Audio\EditorAudioController;

if (User::isLoggedIn()) {
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
