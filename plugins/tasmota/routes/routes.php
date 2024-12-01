<?php

use Ivy\User;

if (User::isLoggedIn()) {
    global $router;
    $router->post('/tasmota/post', '\Tasmota\Settings@post');
}
