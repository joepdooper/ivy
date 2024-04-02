<?php
// version
define('_IVY_VERSION', '0.7.1');
// public
define('_PUBLIC', DIRECTORY_SEPARATOR . 'public');
// subfolder
$scriptPath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_FILENAME']));
$scriptPath = rtrim($scriptPath, '/'); // Remove trailing slash
$scriptPath = str_replace($_SERVER['DOCUMENT_ROOT'], '', $scriptPath);
// $scriptPath = str_replace(_PUBLIC, '', $scriptPath);
$scriptPath = ($scriptPath !== '' ? $scriptPath : '');
define('_SUBFOLDER', $scriptPath . DIRECTORY_SEPARATOR);
// root
define('_ROOT', $_SERVER['DOCUMENT_ROOT']);
// protocol http or https
define('_PROTOCOL', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http');
// base url of blog
define('_DOMAIN', _PROTOCOL . '://' . $_SERVER['SERVER_NAME']);
// current page
define('_CURRENT_PAGE', _PROTOCOL . '://' .$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
// base url of blog
$serverPort = ($_SERVER['SERVER_PORT'] != 80) ? (":" . $_SERVER['SERVER_PORT']) : '';
define('_BASE_PATH', _DOMAIN . $serverPort . _SUBFOLDER);
// root server
define('_PUBLIC_PATH', _ROOT . _SUBFOLDER);
// main upload folder images
define('_MEDIA_PATH', "media" . DIRECTORY_SEPARATOR);
// plugin directory
define('_PLUGIN_PATH', "plugins" . DIRECTORY_SEPARATOR);
// template directory
define('_TEMPLATES_PATH', "templates" . DIRECTORY_SEPARATOR);
