<?php

use Ivy\User;

if (User::getAuth()->isLoggedIn()) {
    global $router;
    $router->post('/tasmota/post', '\Tasmota\Settings@post');
}
