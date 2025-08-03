<?php

use Ivy\Core\Path;

spl_autoload_register(function ($classname) {
    $classname = str_replace('\\', DIRECTORY_SEPARATOR, $classname);
    $namespace = dirname(str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $classname));

    $directory = Path::get('PROJECT_PATH') . 'plugins' . DIRECTORY_SEPARATOR . strtolower($namespace) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR;

    $filePath = $directory . basename($classname) . '.php';
    if (file_exists($filePath)) {
        require_once($filePath);
    }
});