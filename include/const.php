<?php
// Check if the script is running in CLI or web context
$scriptFilename = $_SERVER['SCRIPT_FILENAME'] ?? '';
$documentRoot = $_SERVER['DOCUMENT_ROOT'] ?? '';

// Handle SCRIPT_FILENAME
$scriptPath = str_replace('\\', '/', dirname($scriptFilename));
$scriptPath = rtrim($scriptPath, '/'); // Remove trailing slash
$scriptPath = str_replace($documentRoot, '', $scriptPath);
$scriptPath = ltrim($scriptPath, '/'); // Remove leading slash
define('_SUBFOLDER', $scriptPath !== '' ? $scriptPath . DIRECTORY_SEPARATOR : '');

// Handle other server variables
define('_ROOT', $documentRoot . DIRECTORY_SEPARATOR);
define('_PROTOCOL', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http');
define('_DOMAIN', _PROTOCOL . '://' . ($_SERVER['SERVER_NAME'] ?? 'localhost'));
define("_CURRENT_PAGE", _PROTOCOL . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . ($_SERVER['REQUEST_URI'] ?? '/'));

$serverPort = ($_SERVER['SERVER_PORT'] ?? 80) != 80 ? (":" . ($_SERVER['SERVER_PORT'] ?? '')) : '';

// Correctly handle the base path
$basePath = rtrim(_DOMAIN . $serverPort . '/' . _SUBFOLDER, '/');
define("_BASE_PATH", $basePath . '/');

// Define other constants
const _IVY_VERSION = '0.8.0';
const _PUBLIC_PATH = _ROOT . _SUBFOLDER;
const _MEDIA_PATH = "media" . DIRECTORY_SEPARATOR;
const _PLUGIN_PATH = "plugins" . DIRECTORY_SEPARATOR;
const _TEMPLATES_PATH = "templates" . DIRECTORY_SEPARATOR;
