<?php
defined('_BASE_PATH') or die('Something went wrong');

use Ivy\Template;
use Ivy\User;

global $router, $db, $auth;

Template::file('head.php', null, 'head');
Template::file('body.php', null, 'body');

// -- START
$router->match('GET', '/', function() use($db, $auth) {
    $items = (new \Ivy\Item)->where('parent',null)->orderBy(['sort', 'date', 'id'],'asc')->get()->data();
    Template::file('include/start.php', $items, 'main');
});

// -- ADMIN
$router->get('/admin/(\w+)', function($id) use($db, $auth) {
    if(User::canEditAsAdmin($auth) || (!User::canEditAsAdmin($auth) && in_array($id,['register','login','logout','reset','profile']))):
        Template::file('admin/' . $id . '.php', null, 'main');
    endif;
});

// -- PLUGIN
$router->get('/plugin/(\w+)', function($id) use($db, $auth) {
    Template::file(_PLUGIN_PATH . $id . '/template/' . 'settings.php', null, 'main');
});

// -- PROFILE
$router->get('/profile/(\d+)', function($id) use($db, $auth) {
    $profile = (new \Ivy\Profile)->where('id',$id)->getRow()->data();
    Template::file('include/profile.php', $profile, 'main');
});

Template::addCSS('css/normalize.css');
Template::addCSS('css/style_root.css');
Template::addCSS('css/simple-grid.css');
Template::addCSS('css/style.css');
Template::addCSS('css/swup.css');
Template::addCSS('css/overlay.css');
Template::addCSS('css/style_sub.css');
Template::addJS("node_modules/axios/dist/axios.min.js");
Template::addJS("node_modules/petite-vue/dist/petite-vue.umd.js");
Template::addJS("templates/base/js/template.js");