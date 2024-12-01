<?php

global $router;

use Article\AdminArticleController;
use Article\ArticleController;
use Ivy\User;

$router->get('/article/([a-z0-9_-]+)', function ($slug) {
    (new ArticleController)->page($slug);
});

if (User::isLoggedIn()) {
    if (User::canEditAsEditor()) {
        global $router;

        $router->match('GET|POST', '/article/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', function ($id, $template_route = null, $identifier = null) {
            (new AdminArticleController)->insert($id, $template_route, $identifier);
        });

        $router->match('GET|POST', '/article/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', function ($id, $template_route = null, $identifier = null) {
            (new AdminArticleController)->update($id, $template_route, $identifier);
        });

        $router->match('GET|POST', '/article/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', function ($id, $template_route = null, $identifier = null) {
            (new AdminArticleController)->delete($id, $template_route, $identifier);
        });
    }
}