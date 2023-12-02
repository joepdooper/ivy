<?php
spl_autoload_register(function ($className) {

  $nameSpace = '';

  $len = strlen($nameSpace);
  if (strncmp($className, $nameSpace, $len) === 0) {
    $className = substr($className, $len);
    $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
  }

  $classFile = _PUBLIC_PATH . 'core/classes/' . $className . '.php';

  if (file_exists($classFile)) {
    require_once($classFile);
  }
});
?>
