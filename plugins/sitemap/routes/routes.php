<?php

use Ivy\User;

if (User::isLoggedIn()) {
    if (User::canEditAsEditor()) {
        global $router;

        $router->post('/sitemap/post', '\Sitemap\Settings@post');
    }
}
