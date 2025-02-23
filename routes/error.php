<?php

use Ivy\App;
use Ivy\Setting;
use Ivy\Template;
use Ivy\User;

// -- 404
App::router()->set404(function () {
    header('HTTP/1.1 404 Not Found');
});
