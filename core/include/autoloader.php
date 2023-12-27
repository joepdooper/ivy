<?php
spl_autoload_register(function ($classname) {
  $classname = str_replace('\\', DIRECTORY_SEPARATOR, $classname);
  $namespace = dirname(str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $classname));

  $directories = [
    _PUBLIC_PATH . 'core' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $namespace . DIRECTORY_SEPARATOR,
    _PUBLIC_PATH . 'plugins' . DIRECTORY_SEPARATOR . $namespace . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR,
  ];

  foreach ($directories as $directory) {
    $filePath = $directory . basename($classname) . '.php';
    if (file_exists($filePath)) {
      require_once($filePath);
      return;
    }
  }
});
?>
