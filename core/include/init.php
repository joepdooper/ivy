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

// template
$sql = 'SELECT `value` FROM `template` WHERE `type` = :type';
define('_TEMPLATE_BASE', _TEMPLATES_PATH . $db->selectValue($sql, ['base']) . DIRECTORY_SEPARATOR);
define('_TEMPLATE_SUB', _TEMPLATES_PATH . $db->selectValue($sql, ['sub']) . DIRECTORY_SEPARATOR);

// hooks
require_once _PUBLIC_PATH . 'vendor/bainternet/php-hooks/php-hooks.php';
$hooks = new Hooks();

// globals
$option = (new \Ivy\Option)->get()->setKeyBy('name')->data();
$info = (new \Ivy\Info)->get()->setKeyBy('name')->data();
$page = new \Ivy\Page();
$button = new \Ivy\Button();

// core JS
$page->addJS("core/js/helper.js");

// Loop through hooks from plugin
$plugins = $db->select('SELECT * FROM `plugin`');
$_SESSION['plugins_active'] = array();
if($plugins):
  foreach($plugins as $plugin):
    if($plugin['active'] == '1'):
      $_SESSION['plugins_active'][] = $plugin['name'];
      include _PUBLIC_PATH . _PLUGIN_PATH.$plugin['folder'].'/hooks/hook.add_action.php';
    endif;
  endforeach;
endif;

// Minify
use MatthiasMullie\Minify;

function minify_css_files(){
  global $option, $page;

  $minify = new Minify\CSS();

  if($option['minify_css']->bool){
    if(!file_exists($page->setTemplateFile('css/minified.css'))){
      foreach($page->css as $cssfile){
        $sourcePath = $page->setTemplateFile($cssfile);
        $minify->add($sourcePath);
      }
      $minify->minify(_PUBLIC_PATH . _TEMPLATE_SUB . 'css/minified.css');
    }
  } else {
    if(file_exists($page->setTemplateFile('css/minified.css'))){
      unlink($page->setTemplateFile('css/minified.css'));
    }
  }

}

$hooks->add_action('add_css_action','minify_css_files','9999');

function minify_js_files(){
  global $option, $page;

  $minify = new Minify\JS();

  if($option['minify_js']->bool){
    if(!file_exists($page->setTemplateFile('js/minified.js'))){
      foreach($page->js as $jsfile){
        $sourcePath = $page->setTemplateFile($jsfile);
        $minify->add($sourcePath);
      }
      $minify->minify(_PUBLIC_PATH . _TEMPLATE_SUB . 'js/minified.js');
    }
  } else {
    if(file_exists($page->setTemplateFile('js/minified.js'))){
      unlink($page->setTemplateFile('js/minified.js'));
    }
  }

}

$hooks->add_action('add_js_action','minify_js_files','9999');
?>
