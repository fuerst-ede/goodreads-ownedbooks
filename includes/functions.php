<?php


define('CLASS_DIR', APP_ROOT.'model/');
define('CONTROLLER_DIR', APP_ROOT.'controller/');

if (USE_INTERNAL_AUTOLOAD) {
  set_include_path(get_include_path().PATH_SEPARATOR.CLASS_DIR.PATH_SEPARATOR.CONTROLLER_DIR);
  spl_autoload_register();
}
else {
  spl_autoload_register(function($class) {
    if (substr($class, 0, 10) == 'controller') {
      $classPath = APP_ROOT . str_replace('\\', '/', $class).".php";
      include_once($classPath);
    }
    else {
      $classPath = CLASS_DIR . str_replace('\\', '/', $class).".php";
      include_once($classPath);
    }
  });
}