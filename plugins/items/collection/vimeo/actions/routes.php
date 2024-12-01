<?php

use Ivy\User;
use Vimeo\AdminVimeoController;

if (User::isLoggedIn()) {
    if (User::canEditAsEditor()) {
        global $router;

        $router->match('GET|POST', '/vimeo/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', function ($id, $template_route = null, $identifier = null) {
            (new AdminVimeoController)->insert($id, $template_route, $identifier);
        });

        $router->match('GET|POST', '/vimeo/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', function ($id, $template_route = null, $identifier = null) {
            (new AdminVimeoController)->update($id, $template_route, $identifier);
        });

        $router->match('GET|POST', '/vimeo/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', function ($id, $template_route = null, $identifier = null) {
            (new AdminVimeoController)->delete($id, $template_route, $identifier);
        });
    }
}