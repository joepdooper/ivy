<?php

// vendor autoload
use Bramus\Router\Router;
use Ivy\DB;
use Ivy\Language;
use Ivy\Setting;
use Ivy\Template;
use Ivy\User;

require_once _PUBLIC_PATH . 'vendor/autoload.php';

// core autoload
require_once _PUBLIC_PATH . 'core/include/autoloader.php';

// load .env and set $_ENV
$dotenv = Dotenv\Dotenv::createImmutable(_PUBLIC_PATH);
$dotenv->load();

// database connect
new DB();

// authentication
User::auth();

// set settings
(new Setting)->get()->setKeyBy('name')->stash()->all();

// template
$sql = "SELECT `value` FROM `template` WHERE `type` = :type";
define('_TEMPLATE_BASE', _TEMPLATES_PATH . DB::$connection->selectValue($sql, ['base']) . DIRECTORY_SEPARATOR);
define('_TEMPLATE_SUB', _TEMPLATES_PATH . DB::$connection->selectValue($sql, ['sub']) . DIRECTORY_SEPARATOR);

// core JS
Template::addJS("core/js/helper.js");

// start router
$router = new Router();
$router->setBasePath(_SUBFOLDER);

// template assets, hooks and routes
include Template::file('template.php');

Language::setDefaultLang(substr(Setting::$stash['language']->value, 0, 2));

// plugin actions
$sql = "SELECT * FROM `plugin` WHERE `active` = :active";
$plugins = DB::$connection->select($sql, [1]);

if ($plugins) {
    $_SESSION['plugin_actives'] = array_column($plugins, 'name');
    foreach ($plugins as $plugin) {
        if (file_exists(_PUBLIC_PATH . _PLUGIN_PATH . $plugin['url'] . DIRECTORY_SEPARATOR . 'plugin.php')) {
            include _PUBLIC_PATH . _PLUGIN_PATH . $plugin['url'] . DIRECTORY_SEPARATOR . 'plugin.php';
        }
    }
}

// core assets and routes
include _PUBLIC_PATH . 'core/include/routes.php';

// run router
$router->run();

function __($language_key)
{
    return Language::get($language_key);
}

function pa($data)
{
    print '<pre>';
    print_r($data);
    print '</pre>';
    print '<br>';
}