<?php

use Ivy\User;

if (User::getAuth()->isLoggedIn()) {
    if (User::canEditAsEditor()) {
        global $router;
        $router->post('/bandsintown/post', '\bandsintown\Settings@post');
        $router->post('/bandsintown/render', '\bandsintown\Settings@render');
    }
}