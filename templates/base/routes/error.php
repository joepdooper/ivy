<?php

use Ivy\Shared\Infrastructure\Manager\RouterManager;

// -- 404
RouterManager::router()->set404(function () {
    header('HTTP/1.1 404 Not Found');
});