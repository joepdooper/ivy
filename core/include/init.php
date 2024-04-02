<?php

use Ivy\Plugin;
use Ivy\Setting;
use Ivy\Template;
use Ivy\User;

// vendor autoload
require_once _PUBLIC_PATH . 'vendor/autoload.php';

// load .env and set $_ENV
$dotenv = Dotenv\Dotenv::createImmutable(_PUBLIC_PATH);
$dotenv->load();

// database access
try {
    $pdo = new PDO("mysql:host=" . $_ENV['DB_SERVER'] . ";port=" . $_ENV['DB_PORT'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8", $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
} catch(PDOException $e) {
    die("ERROR: Could not connect. ");
}
$db = \Delight\Db\PdoDatabase::fromPdo($pdo);

// authentication
$auth = new \Delight\Auth\Auth($db,true);

// hooks
$hooks = new Hooks();

// core autoload
require_once _PUBLIC_PATH . 'core/include/autoloader.php';

// set settings
(new Setting)->get()->setKeyBy('name')->cache()->data();

// template
$sql = "SELECT `value` FROM `template` WHERE `type` = :type";
define('_TEMPLATE_BASE', _TEMPLATES_PATH . $db->selectValue($sql, ['base']) . DIRECTORY_SEPARATOR);
define('_TEMPLATE_SUB', _TEMPLATES_PATH . $db->selectValue($sql, ['sub']) . DIRECTORY_SEPARATOR);

// core JS
Template::addJS("core/js/helper.js");

// start router
$router = new \Bramus\Router\Router();
$router->setBasePath(_SUBFOLDER);

// template hooks and routes
include Template::file('actions/basic.php');
if (Template::file('actions/editor.php')) {
    include Template::$file;
}
if (Template::file('actions/admin.php')) {
    include Template::$file;
}

// plugin actions
$sql = "SELECT * FROM `plugin` WHERE `active` = :active";
$plugins = $db->select($sql,[1]);

if ($plugins) {
    $_SESSION['plugin_actives'] = array_column($plugins, 'name');
    foreach ($plugins as $plugin) {
        if (file_exists(_PUBLIC_PATH . _PLUGIN_PATH . $plugin['url'] . DIRECTORY_SEPARATOR . 'actions/basic.php')) {
            include _PUBLIC_PATH . _PLUGIN_PATH . $plugin['url'] . DIRECTORY_SEPARATOR . 'actions/basic.php';
        }
        if($auth->isLoggedIn()){
            if(User::canEditAsEditor($auth)){
                if (file_exists(_PUBLIC_PATH . _PLUGIN_PATH . $plugin['url'] . DIRECTORY_SEPARATOR . 'actions/editor.php')) {
                    include _PUBLIC_PATH . _PLUGIN_PATH . $plugin['url'] . DIRECTORY_SEPARATOR . 'actions/editor.php';
                }
            }
            if(User::canEditAsAdmin($auth)){
                if (file_exists(_PUBLIC_PATH . _PLUGIN_PATH . $plugin['url'] . DIRECTORY_SEPARATOR . 'actions/admin.php')) {
                    include _PUBLIC_PATH . _PLUGIN_PATH . $plugin['url'] . DIRECTORY_SEPARATOR . 'actions/admin.php';
                }
            }
        }
    }
}

// standard routes
include _PUBLIC_PATH . 'core/include/routes.php';

// run router
$router->run();