<?php

use Ivy\User;

if (User::isLoggedIn()) {
    if (User::canEditAsEditor()) {
        global $router;
        $router->post('/bandsintown/post', '\bandsintown\Settings@post');
        $router->post('/bandsintown/render', '\bandsintown\Settings@render');
    }
}