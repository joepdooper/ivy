<?php
// vendor autoload
require_once _PUBLIC_PATH . 'vendor/autoload.php';

// load .env and set $_ENV
$dotenv = Dotenv\Dotenv::createImmutable(_PUBLIC_PATH);
$dotenv->load();

// database access
try {
  $pdo = new PDO("mysql:host=" . $_ENV['DB_SERVER'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8", $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
} catch(PDOException $e) {
  die("ERROR: Could not connect.");
}
$db = \Delight\Db\PdoDatabase::fromPdo($pdo);

// authentication
$auth = new \Delight\Auth\Auth($db,true);
require_once _PUBLIC_PATH . 'core/include/auth.php';

// core autoload
require_once _PUBLIC_PATH . 'core/include/autoloader.php';

// hooks
require_once _PUBLIC_PATH . 'vendor/bainternet/php-hooks/php-hooks.php';
$hooks = new Hooks();

// globals
$setting = (new \Ivy\Setting)->get()->setKeyBy('name')->data();
$template = new \Ivy\Template();
$button = new \Ivy\Button();

// template
$sql = 'SELECT `value` FROM `template` WHERE `type` = :type';
define('_TEMPLATE_BASE', _TEMPLATES_PATH . $db->selectValue($sql, ['base']) . DIRECTORY_SEPARATOR);
define('_TEMPLATE_SUB', _TEMPLATES_PATH . $db->selectValue($sql, ['sub']) . DIRECTORY_SEPARATOR);

// template hooks
include $template->setTemplateFile('hooks/hook.basic.php');
$hook_template_editor = $template->setTemplateFile('hooks/hook.editor.php');
if (file_exists($hook_template_editor )) {
  include $hook_template_editor;
}
$hook_template_admin = $template->setTemplateFile('hooks/hook.admin.php');
if (file_exists($hook_template_admin )) {
  include $hook_template_admin;
}

// core JS
$template->addJS("core/js/helper.js");

// Loop through hooks from plugin
$plugins = (new \Ivy\Plugin)->get()->data();
$_SESSION['plugins_active'] = array();
if($plugins):
  foreach($plugins as $plugin):
    if($plugin->active == '1'):
      $_SESSION['plugins_active'][] = $plugin->name;
      $hook_file_basic = _PUBLIC_PATH . _PLUGIN_PATH . $plugin->url . '/hooks/hook.add_action.php';
      if (file_exists($hook_file_basic)) {
        include $hook_file_basic;
      }
      if($auth->isLoggedIn()){
        if(canEditAsEditor($auth)){
          $hook_file_editor = _PUBLIC_PATH . _PLUGIN_PATH . $plugin->url . '/hooks/hook.editor.php';
          if (file_exists($hook_file_editor)) {
            include $hook_file_editor;
          }
        }
        if(canEditAsAdmin($auth)){
          $hook_file_admin = _PUBLIC_PATH . _PLUGIN_PATH . $plugin->url . '/hooks/hook.admin.php';
          if (file_exists($hook_file_admin)) {
            include $hook_file_admin;
          }
        }
      }
    endif;
  endforeach;
endif;

// Minify
use MatthiasMullie\Minify;

function minify_css_files(){
  global $setting, $template;

  $minify = new Minify\CSS();

  if($setting['minify_css']->bool){
    if(!file_exists($template->setTemplateFile('css/minified.css'))){
      foreach($template->css as $cssfile){
        $sourcePath = $template->setTemplateFile($cssfile);
        $minify->add($sourcePath);
      }
      $minify->minify(_PUBLIC_PATH . _TEMPLATE_SUB . 'css/minified.css');
    }
  } else {
    if(file_exists($template->setTemplateFile('css/minified.css'))){
      unlink($template->setTemplateFile('css/minified.css'));
    }
  }

}

$hooks->add_action('add_css_action','minify_css_files','9999');

function minify_js_files(){
  global $setting, $template;

  $minify = new Minify\JS();

  if($setting['minify_js']->bool){
    if(!file_exists($template->setTemplateFile('js/minified.js'))){
      foreach($template->js as $jsfile){
        $sourcePath = $template->setTemplateFile($jsfile);
        $minify->add($sourcePath);
      }
      $minify->minify(_PUBLIC_PATH . _TEMPLATE_SUB . 'js/minified.js');
    }
  } else {
    if(file_exists($template->setTemplateFile('js/minified.js'))){
      unlink($template->setTemplateFile('js/minified.js'));
    }
  }

}

$hooks->add_action('add_js_action','minify_js_files','9999');
?>
