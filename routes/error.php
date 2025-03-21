<?php

use Ivy\App;

// -- 404
App::router()->set404(function () {
    header('HTTP/1.1 404 Not Found');
});
