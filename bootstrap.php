<?php

error_reporting(E_ALL & ~E_NOTICE);

define('GOV_STARTED', true);
define('APP_ROOT', __DIR__ . '/');


require_once('includes/config.php');
require_once('includes/functions.php');

$urlParts = \framework\url::getUrlArray();

$controllerName = $urlParts[0] ?? '';
$subcontrollerName = $urlParts[1] ?? '';
if (\framework\url::controllerExists($controllerName)) {
  $fullname = 'controller\\'.$controllerName;
  $controller = new $fullname();
  $controller->run();
}
else if (\framework\url::controllerExists($controllerName, $subcontrollerName)) {
  $fullname = 'controller\\'.$controllerName.'\\'.$subcontrollerName;
  $controller = new $fullname();
  $controller->run();
}
else {
  $controller = new controller\index();
  $controller->run();
}

die();