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
require_once _PUBLIC_PATH . 'core/include/auth.php';

// hooks
$hooks = new Hooks();

// core autoload
require_once _PUBLIC_PATH . 'core/include/autoloader.php';

// settings
(new \Ivy\Setting)->get()->setKeyBy('name')->cache()->data();

// template
$sql = "SELECT `value` FROM `template` WHERE `type` = :type";
define('_TEMPLATE_BASE', _TEMPLATES_PATH . $db->selectValue($sql, ['base']) . DIRECTORY_SEPARATOR);
define('_TEMPLATE_SUB', _TEMPLATES_PATH . $db->selectValue($sql, ['sub']) . DIRECTORY_SEPARATOR);

// core JS
\Ivy\Template::addJS("core/js/helper.js");

// template hooks
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
$router = new \Bramus\Router\Router();
$router->setBasePath(_SUBFOLDER);
$plugin = new \Ivy\Plugin;
$plugin->run();
include _PUBLIC_PATH . 'core/include/routes.php';
$router->run();

// minify
use MatthiasMullie\Minify;

function minify_css_files(): void
{
    $minify = new Minify\CSS();

    if(\Ivy\Setting::$cache['minify_css']->bool){
        if(!file_exists(\Ivy\Template::setTemplateFile('css/minified.css'))){
            foreach(\Ivy\Template::$css as $cssfile){
                $sourcePath = \Ivy\Template::setTemplateFile($cssfile);
                $minify->add($sourcePath);
            }
            $minify->minify(_PUBLIC_PATH . _TEMPLATE_SUB . 'css/minified.css');
        }
    } else {
        if(file_exists(\Ivy\Template::setTemplateFile('css/minified.css'))){
            unlink(\Ivy\Template::setTemplateFile('css/minified.css'));
        }
    }

}

$hooks->add_action('add_css_action','minify_css_files','9999');

function minify_js_files(): void
{
    $minify = new Minify\JS();

    if(\Ivy\Setting::$cache['minify_js']->bool){
        if(!file_exists(\Ivy\Template::setTemplateFile('js/minified.js'))){
            foreach(\Ivy\Template::$js as $jsfile){
                $sourcePath = \Ivy\Template::setTemplateFile($jsfile);
                $minify->add($sourcePath);
            }
            $minify->minify(_PUBLIC_PATH . _TEMPLATE_SUB . 'js/minified.js');
        }
    } else {
        if(file_exists(\Ivy\Template::setTemplateFile('js/minified.js'))){
            unlink(\Ivy\Template::setTemplateFile('js/minified.js'));
        }
    }

}

$hooks->add_action('add_js_action','minify_js_files','9999');