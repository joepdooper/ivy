<?php
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
(new \Ivy\Setting)->get()->setKeyBy('name')->cache()->data();

// template
$sql = "SELECT `value` FROM `template` WHERE `type` = :type";
define('_TEMPLATE_BASE', _TEMPLATES_PATH . $db->selectValue($sql, ['base']) . DIRECTORY_SEPARATOR);
define('_TEMPLATE_SUB', _TEMPLATES_PATH . $db->selectValue($sql, ['sub']) . DIRECTORY_SEPARATOR);

// core JS
\Ivy\Template::addJS("core/js/helper.js");

// start router
$router = new \Bramus\Router\Router();
$router->setBasePath(_SUBFOLDER);

// template hooks and routes
include \Ivy\Template::setTemplateFile('hooks/hook.basic.php');
$hook_template_editor = \Ivy\Template::setTemplateFile('hooks/hook.editor.php');
if (file_exists($hook_template_editor)) {
    include $hook_template_editor;
}
$hook_template_admin = \Ivy\Template::setTemplateFile('hooks/hook.admin.php');
if (file_exists($hook_template_admin)) {
    include $hook_template_admin;
}

// plugin hooks and routes
$plugin = new \Ivy\Plugin;
$plugin->run();

// standard routes
include _PUBLIC_PATH . 'core/include/routes.php';

// run router
$router->run();