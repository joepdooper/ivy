<?php

use Ivy\Template;
use Ivy\User;
use Items\Collections\Vimeo\AdminVimeoController;

function add_vimeo_player(): void
{
    if (!in_array("IframeManager", $_SESSION['plugin_actives'])):
        if (isset($_COOKIE['cc_cookie'])):
            $cc_cookie = json_decode($_COOKIE['cc_cookie']);
            $cc_cookie->necessary = in_array("necessary", $cc_cookie->categories);
            $cc_cookie->analytics = in_array("analytics", $cc_cookie->categories);
            $cc_cookie->targeting = in_array("targeting", $cc_cookie->categories);
        endif;
        $scriptattribute = (isset($cc_cookie) && $cc_cookie->analytics) ?: "type='text/plain' data-cookiecategory='analytics'";
        print "<script " . $scriptattribute . " src='https://unpkg.com/@vimeo/player'></script>";
        print "<script " . $scriptattribute . " src='" . Path::get('BASE_PATH') . "plugins/vimeo/js/vimeo.js'></script>";
    endif;
}

Template::hooks()->add_action('add_js_action', 'add_vimeo_player');

if (User::getAuth()->isLoggedIn()) {
    if (User::canEditAsEditor()) {
        global $router;

        $router->match('GET|POST', '/vimeo/insert/(\d+)(/\w+)?(/[a-z0-9_-]+)?', function ($id, $template_route = null, $identifier = null) {
            (new AdminVimeoController)->insert($id, $template_route, $identifier);
        });

        $router->match('GET|POST', '/vimeo/update/(\d+)(/\w+)?(/[a-z0-9_-]+)?', function ($id, $template_route = null, $identifier = null) {
            (new AdminVimeoController)->update($id, $template_route, $identifier);
        });

        $router->match('GET|POST', '/vimeo/delete/(\d+)(/\w+)?(/[a-z0-9_-]+)?', function ($id, $template_route = null, $identifier = null) {
            (new AdminVimeoController)->delete($id, $template_route, $identifier);
        });
    }
}