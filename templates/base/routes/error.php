<?php

use Ivy\Shared\Infrastructure\Manager\RouterManager;
use Ivy\Template\Presentation\View\View;

// -- 404
RouterManager::router()->set404(function () {
    View::render("errors/page_not_found.latte");
});

// -- 403
RouterManager::error(403, function (string $message) {
    View::render('errors/forbidden.latte', [
        'code' => 403,
        'message' => $message,
    ]);
});

// -- 500
RouterManager::error(500, function (string $message) {
    View::render('errors/server_error.latte', [
        'code' => 500,
        'message' => $message,
    ]);
});