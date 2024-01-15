<?php
defined('_BASE_PATH') or die('Something went wrong');

function add_darkmode_buttons(){
  global $template;
  include $template->setTemplateFile(_PLUGIN_PATH . "DarkMode/template/buttons.php");
}

function add_darkmode_checkbox(){
  global $template;
  $checked = (isset($_SESSION['darkMode']) && $_SESSION['darkMode']) ? true : false;
  include $template->setTemplateFile(_PLUGIN_PATH . "DarkMode/template/checkbox.php");
}

function add_darkmode_css(){
  global $template;
  $template->addCSS(_PLUGIN_PATH . "DarkMode/css/dark-mode.css");
}

function add_darkmode_js(){
  global $template;
  $template->addJS(_PLUGIN_PATH . "DarkMode/js/dark-mode.js");
}

function set_darkmode_route(){
  global $router;
  $router->post('/darkmode/toggle/', function(){
    $_POST = json_decode(file_get_contents("php://input"),true);
    $_SESSION['darkMode'] = $_POST['darkMode'];
    echo json_encode("success");
    exit;
  });
}

$hooks->add_action('dark_mode_buttons','add_darkmode_buttons');
$hooks->add_action('start_body_action','add_darkmode_checkbox',2);
$hooks->add_action('add_css_action','add_darkmode_css',2);
$hooks->add_action('start_body_action','add_darkmode_js',12);
$hooks->add_action('start_router_action','set_darkmode_route');

?>
