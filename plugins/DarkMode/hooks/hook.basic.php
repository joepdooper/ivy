<?php
defined('_BASE_PATH') or die('Something went wrong');
global $router;

$router->post('/darkmode/toggle/', function(){
    $_POST = json_decode(file_get_contents("php://input"),true);
    $_SESSION['darkMode'] = $_POST['darkMode'];
    echo json_encode("success");
    exit;
});

\Ivy\Template::addCSS(_PLUGIN_PATH . "DarkMode/css/dark-mode.css");
\Ivy\Template::addJS(_PLUGIN_PATH . "DarkMode/js/dark-mode.js");

// -- hooks

function add_darkmode_buttons(): void
{
  include \Ivy\Template::setTemplateFile(_PLUGIN_PATH . "DarkMode/template/buttons.php");
}

function add_darkmode_checkbox(): void
{
  $checked = isset($_SESSION['darkMode']) && $_SESSION['darkMode'];
  include \Ivy\Template::setTemplateFile(_PLUGIN_PATH . "DarkMode/template/checkbox.php");
}

global $hooks;
$hooks->add_action('dark_mode_buttons','add_darkmode_buttons');
$hooks->add_action('start_body_action','add_darkmode_checkbox',2);
