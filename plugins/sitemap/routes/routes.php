<?php

use Ivy\User;

if (User::getAuth()->isLoggedIn()) {
    if (User::canEditAsEditor()) {
        global $router;

        $router->post('/sitemap/post', '\Sitemap\Settings@post');
    }
}
