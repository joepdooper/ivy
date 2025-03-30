<?php

use Ivy\Manager\RouterManager;

// -- 404
RouterManager::instance()->set404(function () {
    header('HTTP/1.1 404 Not Found');
});
